<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\User;
use App\Models\Role;
use App\Models\UserModel;
use Illuminate\Http\Request;


class UserController extends BaseController
{
    private $userModel;
    private $roleModel;


    public function __construct()
    {
        // Áp dụng middleware để kiểm tra quyền admin
        $route = $this->getRouteByRole();
        $roleBase = 'admin';
        $role = $this->getRole();
        if ($role !== $roleBase) {
            $this->redirect($route);
        }


        $this->userModel = new User();
        $this->roleModel = new Role();
    }


    // -------------
    // Users
    // -------------

    public function index()
    {
        $currentUser = $this->getCurrentUser();

        $users = [];
        $query = $this->userModel->getAll();
        $roles = $this->roleModel->getAll();

        foreach ($query as $user) {
            $userWithRole = $this->userModel->getUserWithRole($user['id']);
            $users[] = $userWithRole;
        }

        $this->view('admin/users/index', [
            'user' => $currentUser,
            'users' => $users,
            'roles' => $roles
        ]);
    }


    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $full_name = trim($_POST['full_name']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = intval($_POST['role']);
            $status = trim($_POST['status']);
            $avatar = '';

            $errors = [];

            // Validate inputs
            if (empty($username) || strlen($username) < 6) {
                $errors['username'] = 'Tên người dùng phải có ít nhất 6 ký tự';
            } else {
                // Kiểm tra xem username đã tồn tại chưa
                $existingUser = $this->userModel->findByUsername($username);
                if ($existingUser) {
                    $errors['username'] = 'Tên người dùng đã tồn tại, vui lòng chọn tên khác';
                }
            }


            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Vui lòng nhập email hợp lệ';
            } elseif ($this->userModel->findByEmail($email)) {
                $errors['email'] = 'Email này đã được sử dụng';
            }

            // Handle file upload if needed here

            // Only proceed with saving if there are no errors
            if (empty($errors)) {
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'full_name' => $full_name,
                    'password' => $password,
                    'role_id' => $role,
                    'status' => $status,
                    'avatar' => $avatar
                ];

                $result = $this->userModel->create($data);

                if ($result) {
                    $this->setFlashMessage('success', 'Tạo người dùng thành công');
                    header('Location:' . UrlHelper::route('/admin/users/index'));
                    exit; // Important to prevent further execution
                } else {
                    $errors['database'] = 'Có lỗi xảy ra khi lưu dữ liệu';
                }
            }

            // If we get here, there were errors - show the form again with errors
            $roles = $this->userModel->getAll(); // Assuming this gets roles, not users
            $this->view('admin/users/create', [
                'errors' => $errors,
                'input' => $_POST,
                'roles' => $roles
            ]);
        } else {
            // GET request - show the empty form
            $roles = $this->userModel->getAll(); // This should probably be getRoles() instead
            $this->view('admin/users/create', [
                'roles' => $roles
            ]);
        }
    }


    public function edit($id)
    {
        $currentUser = $this->userModel->findById($id);

        if (!$currentUser) {
            $this->setFlashMessage('error', 'Người dùng không tồn tại');
            header('Location: ' . UrlHelper::route('/admin/users/index'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $full_name = trim($_POST['full_name']);
            $role = intval($_POST['role']);
            $status = trim($_POST['status']);

            // Nếu không nhập mật khẩu mới, giữ nguyên mật khẩu cũ
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $currentUser['password'];

            $errors = [];

            if (empty($username) || strlen($username) < 6) {
                $errors['username'] = 'Tên người dùng phải có ít nhất 6 ký tự';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Vui lòng nhập email hợp lệ';
            } elseif ($this->userModel->findByEmail($email) && $email !== $currentUser['email']) {
                $errors['email'] = 'Email này đã được sử dụng';
            }

            if (empty($errors)) {
                $data = [
                    // Không thêm 'id' vào mảng data
                    'username' => $username,
                    'email' => $email,
                    'full_name' => $full_name,
                    'password' => $password,
                    'role_id' => $role,
                    'status' => $status,
                ];

                // Truyền id riêng biệt
                $result = $this->userModel->update($id, $data);

                if ($result) {
                    $this->setFlashMessage('success', 'Cập nhật người dùng thành công');
                    header('Location: ' . UrlHelper::route('/admin/users/index'));
                    die(); // Dừng chương trình ngay sau khi chuyển hướng

                } else {
                    $errors['database'] = 'Có lỗi xảy ra khi cập nhật dữ liệu';
                }
            }

            $roles = $this->userModel->getAll();
            $this->view('admin/users/edit', [
                'user' => $currentUser,
                'errors' => $errors,
                'input' => $_POST,
                'roles' => $roles
            ]);
        } else {
            $roles = $this->userModel->getAll();
            $this->view('admin/users/edit', ['user' => $currentUser, 'roles' => $roles]);
        }
    }
    public function delete($id) //+
    {
        // Xóa người dùng//-
        // Check if the user exists before deleting//+
        $user = $this->userModel->findById($id); //+
        if (!$user) { //+
            $this->setFlashMessage('error', 'Người dùng không tồn tại'); //+
            header('Location: ' . UrlHelper::route('/admin/users/index')); //+
            exit; //+
        } //+
        //+
        // Delete the user//+
        $this->userModel->delete($id);


        // Redirect to the user list//+
        $this->setFlashMessage('success', 'Xóa người dùng thành công'); //+
        header('Location: ' . UrlHelper::route('/admin/users/index')); //+
        exit; //+
    }
}
