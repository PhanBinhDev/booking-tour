<?php

namespace App\Controllers;

use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;
use App\Models\User;
use App\Models\Booking;
use App\Models\Reviews;
use Exception;
use Stripe\Review;

class UserController extends BaseController
{
    private $userModel;
    private $bookingModel;
    private $reviewsModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->bookingModel = new Booking();
        $this->reviewsModel = new Reviews();
    }

    public function dashboard()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('auth/login'));
        }

        $currentUser = $this->getCurrentUser();



        // Chuyển hướng dựa vào vai trò
        if ($currentUser['role_name'] === 'admin') {
            $this->redirect(UrlHelper::route('admin/dashboard'));
        } elseif ($currentUser['role_name'] === 'moderator') {
            $this->redirect(UrlHelper::route('moderator/dashboard'));
        }

        $this->view('user/dashboard', [
            'user' => $currentUser,


        ]);
    }

    public function profile()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('auth/login'));
        }

        $currentUser = $this->getCurrentUser();
        $userProfile = $this->userModel->getUserProfile($currentUser['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $date_of_birth = $_POST['date_of_birth'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $date_of_birth = $_POST['date_of_birth'] ?? '';
            $bio = $_POST['bio'] ?? '';
            $website = $_POST['website'] ?? '';
            $facebook = $_POST['facebook'] ?? '';
            $twitter = $_POST['twitter'] ?? '';
            $instagram = $_POST['instagram'] ?? '';

            $date_of_birth = $_POST['date_of_birth'] ?? '';
            $bio = $_POST['bio'] ?? '';
            $website = $_POST['website'] ?? '';
            $facebook = $_POST['facebook'] ?? '';
            $twitter = $_POST['twitter'] ?? '';
            $instagram = $_POST['instagram'] ?? '';
            $avatar =  '';
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                try {

                    // Upload ảnh và lưu thông tin
                    $uploadResult = CloudinaryHelper::upload($_FILES['avatar']['tmp_name'], 'categories');

                    if (!isset($uploadResult['secure_url'])) {
                        throw new Exception('Lỗi khi upload ảnh');
                    }

                    $avatar = $uploadResult['secure_url'];
                } catch (Exception $e) {
                    $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                    return;
                }
            }

            $data = [
                'full_name' => $full_name,
                'phone' => $phone,
                'gender' => $gender,
                'address' => $address,
                'gender' => $gender,
                'address' => $address,
                'date_of_birth' => $date_of_birth,
                'bio' => $bio,
                'website' => $website,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'instagram' => $instagram,
                'user_id' => $currentUser['id'],
                'avatar' => $avatar
            ];
            $this->userModel->updateProfile($data);
        }
        $this->view('user/profile', ["currentUser" => $currentUser, "userProfile" => $userProfile]);
    }

    public function changePassword()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('auth/login'));
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';



            if (empty($currentPassword)) {
                $errors['current_password'] = 'Mật khẩu hiện tại là bắt buộc';
            } elseif (!password_verify($currentPassword, $this->getCurrentUser()['password'])) {
                $errors['current_password'] = 'Mật khẩu không chính xác';
            }

            if (empty($newPassword) || strlen($newPassword) < 6) {
                $errors['new_password'] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
            }

            if ($newPassword !== $confirmPassword) {
                $errors['confirm_password'] = 'Mât khẩu không khớp';
            }
            // var_dump($newPassword, $currentPassword);

            if (empty($errors)) {
                if ($this->userModel->updatePassword($this->getCurrentUser()['id'], password_hash($newPassword, PASSWORD_DEFAULT))) {
                    $this->setFlashMessage('success', 'Cập nhật mật khẩu thành công');
                } else {
                    $errors['update'] = 'Cập nhật mật khẩu thất bại';
                }
            }
        }

        $this->view('user/change-password', [
            'errors' => $errors,
        ]);
    }

    public function userBookings()
    {
        $currentUser = $this->getCurrentUser();
        $user_id = $currentUser['id'];
        $collums = 'bookings.*, tours.title, tours.duration, tour_dates.start_date, tour_dates.end_date ';
        $condition = ['user_id' => $user_id];
        $join = [
            "LEFT JOIN tour_dates ON tour_dates.id = bookings.tour_date_id",
            "JOIN tours ON tours.id = bookings.tour_id"
        ];
        $bookings = $this->bookingModel->getAll($collums, $condition, null, null, null, $join);
        // var_dump($bookings);
        $this->view('user/user-bookings', ['bookings' => $bookings]);
    }


    public function wishlist()
    {
        $this->view('user/wishlist');
    }

    public function reviews()
    {
        $currentUser = $this->getCurrentUser();
        $user_id = $currentUser['id'];
        $collums = 'tour_reviews.*, tours.title';
        $condition = ['user_id' => $user_id];
        $join = [
            // "LEFT JOIN bookings ON tour_reviews.bookings_id = bookings.id",
            "JOIN tours ON tours.id = tour_reviews.tour_id"
        ];
        $reviews = $this->reviewsModel->getAll($collums, $condition, null, null, null, $join);
        // var_dump($reviews);
        $this->view('user/reviews', ['reviews' => $reviews]);
    }
    public function deleteReview($id)
    {
        $this->reviewsModel->delete($id);
        header('location:' . UrlHelper::route('user/reviews'));
        $this->setFlashMessage('success', 'Xóa bình luận thành công');
        exit;
    }
}
