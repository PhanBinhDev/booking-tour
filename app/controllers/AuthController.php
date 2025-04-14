<?php

namespace App\Controllers;

use App\Helpers\UrlHelper;
use App\Models\User;
use App\Helpers\EmailHelper;
use App\Helpers\SessionHelper;

class AuthController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Hiển thị và xử lý form đăng nhập
     */
    public function login()
    {
        if ($this->isAuthenticated()) {
            $route = $this->getRouteByRole();
            $this->redirect(UrlHelper::route($route));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']) ? true : false;

            $errors = [];

            if (empty($email)) {
                $errors['email'] = 'Email là bắt buộc';
            }

            if (empty($password)) {
                $errors['password'] = 'Mật khẩu là bắt buộc';
            }

            if (empty($errors)) {
                // Đầu tiên kiểm tra email tồn tại không, trước khi xác thực mật khẩu
                $existingUser = $this->userModel->findByEmail($email);

                if (!$existingUser) {
                    $errors['login'] = 'Tài khoản không tồn tại';
                } else {
                    // Kiểm tra trạng thái tài khoản
                    if ($existingUser['status'] !== 'active') {
                        switch ($existingUser['status']) {
                            case 'inactive':
                                $errors['login'] = 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên để được hỗ trợ.';
                                break;
                            case 'banned':
                                $errors['login'] = 'Tài khoản của bạn đã bị cấm. Vui lòng liên hệ quản trị viên để biết thêm thông tin.';
                                break;
                            default:
                                $errors['login'] = 'Tài khoản không khả dụng.';
                                break;
                        }
                    } else {
                        // Nếu trạng thái active, tiến hành xác thực mật khẩu
                        $user = $this->userModel->authenticate($email, $password);

                        if ($user) {
                            // Kiểm tra xác thực email nếu cần
                            if (REQUIRE_EMAIL_VERIFICATION && !$user['email_verified']) {
                                $errors['login'] = 'Vui lòng xác thực email trước khi đăng nhập';

                                // Gửi lại email xác thực
                                $token = $this->userModel->createVerificationToken($user['id']);
                                if ($token) {
                                    EmailHelper::sendVerificationEmail($user['email'], $user['username'], $token);
                                    $errors['login'] .= '. Chúng tôi đã gửi lại email xác thực.';
                                }
                            } else {
                                // Cập nhật thời gian đăng nhập cuối
                                $this->userModel->update($user['id'], [
                                    'last_login' => date('Y-m-d H:i:s')
                                ]);

                                // Đăng nhập thành công
                                SessionHelper::set('user_id', $user['id']);
                                SessionHelper::set('username', $user['username']);
                                SessionHelper::set('role', $user['role']['name']);
                                SessionHelper::set('role_id', $user['role_id']);
                                SessionHelper::set('permissions', $user['permissions']);

                                // Lưu cookie nếu chọn "Ghi nhớ đăng nhập"
                                if ($remember) {
                                    $token = bin2hex(random_bytes(32));
                                    $expires = time() + (30 * 24 * 60 * 60); // 30 ngày

                                    // Lưu token vào cơ sở dữ liệu
                                    $this->userModel->saveRememberToken($user['id'], $token);

                                    // Đặt cookie
                                    setcookie('remember_token', $token, $expires, '/', '', false, true);
                                    setcookie('user_id', $user['id'], $expires, '/', '', false, true);
                                }

                                // Chuyển hướng đến trang chủ hoặc trang được yêu cầu trước đó
                                $redirect = SessionHelper::get('redirect_url') ?? UrlHelper::route('');

                                // Chuyển hướng admin đến dashboard
                                if ($user['role']['name'] === 'admin') {
                                    $redirect = UrlHelper::route('admin/dashboard');
                                } else if ($user['role']['name'] === 'moderator') {
                                    $redirect = UrlHelper::route('moderator/dashboard');
                                }

                                unset($_SESSION['redirect_url']);

                                $this->redirect($redirect);
                            }
                        } else {
                            $errors['login'] = 'Mật khẩu không đúng';
                        }
                    }
                }
            }

            $this->view('auth/login', [
                'errors' => $errors,
                'email' => $email,
                'remember' => $remember
            ]);
        } else {
            $this->view('auth/login');
        }
    }

    /**
     * Hiển thị và xử lý form đăng ký
     */
    public function register()
    {
        if ($this->isAuthenticated()) {
            // Check role
            // TODO: write a function base on role and redirect
            $route = $this->getRouteByRole();
            $this->redirect(UrlHelper::route($route));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';
            $fullName = $_POST['full_name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $agreeTerms = isset($_POST['agree_terms']) ? true : false;

            $errors = [];

            // Kiểm tra đầu vào
            if (empty($username) || strlen($username) < 3) {
                $errors['username'] = 'Tên đăng nhập phải có ít nhất 3 ký tự';
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $errors['username'] = 'Tên đăng nhập chỉ được chứa chữ cái, số và dấu gạch dưới';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Vui lòng nhập email hợp lệ';
            }

            if (empty($password) || strlen($password) < 6) {
                $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }

            if ($password !== $passwordConfirm) {
                $errors['password_confirm'] = 'Mật khẩu xác nhận không khớp';
            }

            if (!$agreeTerms) {
                $errors['agree_terms'] = 'Bạn phải đồng ý với điều khoản dịch vụ';
            }

            // Kiểm tra email và username đã tồn tại chưa
            if (empty($errors['email']) && $this->userModel->findByEmail($email)) {
                $errors['email'] = 'Email này đã được đăng ký';
            }

            if (empty($errors['username']) && $this->userModel->findByUsername($username)) {
                $errors['username'] = 'Tên đăng nhập này đã được sử dụng';
            }

            if (empty($errors)) {
                $userId = $this->userModel->createUser([
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'full_name' => $fullName,
                    'phone' => $phone,
                    'role_id' => 3,  // Role ID cho người dùng thông thường
                    'status' => 'active',
                    'email_verified' => REQUIRE_EMAIL_VERIFICATION ? 0 : 1
                ]);

                if ($userId) {
                    // Gửi email xác thực nếu cần
                    if (REQUIRE_EMAIL_VERIFICATION) {
                        $token = $this->userModel->createVerificationToken($userId);
                        if ($token) {
                            EmailHelper::sendVerificationEmail($email, $username, $token);
                        }

                        $this->setFlashMessage('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
                        $this->redirect(UrlHelper::route('auth/login'));
                    } else {
                        // Đăng nhập người dùng
                        SessionHelper::set('user_id', $userId);
                        SessionHelper::set('username', $username);
                        SessionHelper::set('role', 'user');
                        SessionHelper::set('role_id', 4);
                        $this->setFlashMessage('success', 'Đăng ký thành công!');
                        $this->redirect(UrlHelper::route(''));
                    }
                } else {
                    var_dump($errors);
                    die();
                    $errors['register'] = 'Đăng ký thất bại. Vui lòng thử lại.';
                }
            }

            $this->view('auth/register', [
                'errors' => $errors,
                'username' => $username,
                'email' => $email,
                'full_name' => $fullName,
                'phone' => $phone
            ]);
        } else {
            $this->view('auth/register');
        }
    }

    /**
     * Xác thực email
     */
    public function verifyEmail()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $this->setFlashMessage('error', 'Token xác thực không hợp lệ');
            $this->redirect(UrlHelper::route('auth/login'));
        }

        $result = $this->userModel->verifyEmail($token);

        if ($result) {
            $this->setFlashMessage('success', 'Xác thực email thành công! Bạn có thể đăng nhập ngay bây giờ.');
        } else {
            $this->setFlashMessage('error', 'Token xác thực không hợp lệ hoặc đã hết hạn');
        }

        $this->redirect(UrlHelper::route('auth/login'));
    }

    /**
     * Hiển thị form quên mật khẩu
     */
    public function forgotPassword()
    {
        // Đã Đăng nhập thì không có vào trang này nữa
        if ($this->isAuthenticated()) {
            $this->redirect(UrlHelper::route(''));
        }
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Vui lòng nhập email hợp lệ';
            }

            if (empty($errors)) {
                $user = $this->userModel->findByEmail($email);

                if ($user) {
                    $token = $this->userModel->createPasswordResetToken($email);
                    // echo $token; die();
                    if ($token) {
                        EmailHelper::sendPasswordResetEmail($email, $user['username'], $token);
                    }
                }

                // Luôn hiển thị thông báo thành công để tránh tiết lộ thông tin tài khoản
                $this->setFlashMessage('success', 'Nếu email tồn tại trong hệ thống, chúng tôi đã gửi hướng dẫn đặt lại mật khẩu.');
                $this->redirect(UrlHelper::route('auth/login'));
            }
        }
        $this->view('/auth/forgot-password', [
            'errors' => $errors,
        ]);
    }

    /**
     * Hiển thị và xử lý form đặt lại mật khẩu
     */
    public function resetPassword($token)
    {
        if ($this->isAuthenticated()) {
            $this->redirect(UrlHelper::route(''));
        }

        if (empty($token)) {
            $this->setFlashMessage('error', 'Token đặt lại mật khẩu không hợp lệ');
            $this->redirect(UrlHelper::route('auth/login'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            $errors = [];

            if (empty($password) || strlen($password) < 6) {
                $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }

            if ($password !== $passwordConfirm) {
                $errors['password_confirm'] = 'Mật khẩu xác nhận không khớp';
            }

            if (empty($errors)) {
                $result = $this->userModel->resetPassword($token, $password);

                if ($result) {
                    $this->setFlashMessage('success', 'Đặt lại mật khẩu thành công! Bạn có thể đăng nhập với mật khẩu mới.');
                    $this->redirect(UrlHelper::route('auth/login'));
                } else {
                    $errors['reset'] = 'Token đặt lại mật khẩu không hợp lệ hoặc đã hết hạn';
                    $this->setFlashMessage('error', 'Đặt lại mật khẩu không thành công!');
                }
            }

            $this->view('auth/reset-password', [
                'errors' => $errors,
                'token' => $token
            ]);
        } else {
            $this->view('auth/reset-password', [
                'token' => $token
            ]);
        }
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        // Xóa cookie nếu có
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
            setcookie('user_id', '', time() - 3600, '/', '', false, true);
        }

        // Xóa session
        session_unset();
        session_destroy();

        $this->redirect(UrlHelper::route('auth/login'));
    }

    /**
     * Kiểm tra xem người dùng đã đăng nhập chưa
     * 
     * @return bool Trạng thái đăng nhập
     */
    public function isAuthenticated()
    {
        return isset($_SESSION['user_id']);
    }

    // GET ROUTE BY ROLE

}