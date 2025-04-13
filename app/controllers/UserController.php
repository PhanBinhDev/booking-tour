<?php

namespace App\Controllers;

use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;
use App\Models\User;
use App\Models\Booking;
use App\Models\Reviews;
use App\Models\Favorites;
use App\Models\Tour;
use Exception;
use Stripe\Review;

class UserController extends BaseController
{
    private $userModel;
    private $bookingModel;
    private $favoriteModel;
    private $reviewsModel;
    private $tourModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->bookingModel = new Booking();
        $this->reviewsModel = new Reviews();
        $this->favoriteModel = new Favorites();
        $this->tourModel = new Tour();
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

    public function favorite()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $currentUser = $this->getCurrentUser();
        $userId = $currentUser['id'];

        // Lấy danh sách ID của các tour yêu thích
        $favoriteTourIds = $this->favoriteModel->getFavoriteTourIdsByUser($userId);

        // Nếu người dùng không có tour yêu thích nào
        if (empty($favoriteTourIds)) {
            $this->view('user/wishlist', [
                'favoriteTours' => [],
                'count' => 0
            ]);
            return;
        }

        $filters = [
            'tour_ids' => $favoriteTourIds
        ];

        $favoriteTours = $this->tourModel->getTours($filters);
        if ($userId) {
            $userFavorites = $this->favoriteModel->getFavoriteTourIdsByUser($userId);
        }

        $this->view('user/wishlist', [
            'favoriteTours' => $favoriteTours,
            'count' => count($favoriteTours),
            "userFavorites" => $userFavorites
        ]);
    }

    public function toggle()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để sử dụng tính năng này']);
            exit;
        }

        // Kiểm tra request method
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $tourId = isset($_POST['tour_id']) ? trim($_POST['tour_id']) : null;

            if (!$tourId) {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin tour']);
                exit;
            }

            $favoriteModel = new Favorites();

            // Kiểm tra xem tour đã được yêu thích chưa
            if ($favoriteModel->checkFavoriteExists($userId, $tourId)) {
                // Nếu đã tồn tại, xóa khỏi danh sách yêu thích
                if ($favoriteModel->removeFavorite($userId, $tourId)) {
                    echo json_encode(['status' => 'success', 'action' => 'removed']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Không thể xóa khỏi danh sách yêu thích']);
                }
            } else {
                // Nếu chưa tồn tại, thêm vào danh sách yêu thích
                if ($favoriteModel->addFavorite($userId, $tourId)) {
                    echo json_encode(['status' => 'success', 'action' => 'added']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Không thể thêm vào danh sách yêu thích']);
                }
            }

            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Phương thức không được hỗ trợ']);
            exit;
        }
    }

    /**
     * Hiển thị form đánh giá tour
     * 
     * @param int $id ID của tour cần đánh giá
     */
    public function reviewTour($id)
    {
        // Kiểm tra đăng nhập
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('auth/login'));
            return;
        }

        $currentUser = $this->getCurrentUser();
        $userId = $currentUser['id'];

        // Lấy thông tin tour
        $tour = $this->tourModel->getTourDetails($id);
        if (!$tour) {
            $this->setFlashMessage('error', 'Không tìm thấy thông tin tour');
            $this->redirect(UrlHelper::route('user/bookings'));
            return;
        }

        // Kiểm tra người dùng đã từng đặt và hoàn thành tour này chưa
        $completedBooking = $this->bookingModel->getCompletedBookingByTourAndUser($id, $userId);
        if (!$completedBooking) {
            $this->setFlashMessage('error', 'Bạn chỉ có thể đánh giá các tour đã hoàn thành');
            $this->redirect(UrlHelper::route('user/bookings'));
            return;
        }

        // Kiểm tra xem đã đánh giá chưa
        $existingReview = $this->reviewsModel->getByTourAndUser($id, $userId);

        $this->view('user/review-form', [
            'tour' => $tour,
            'booking' => $completedBooking,
            'existingReview' => $existingReview
        ]);
    }

    public function submitReview($id)
    {
        // Kiểm tra đăng nhập
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('auth/login'));
            return;
        }

        $currentUser = $this->getCurrentUser();
        $userId = $currentUser['id'];

        // Lấy thông tin tour
        $tour = $this->tourModel->getTourDetails($id);
        if (!$tour) {
            $this->setFlashMessage('error', 'Không tìm thấy thông tin tour');
            $this->redirect(UrlHelper::route('user/bookings'));
            return;
        }

        // Kiểm tra người dùng đã từng đặt và hoàn thành tour này chưa
        $completedBooking = $this->bookingModel->getCompletedBookingByTourAndUser($id, $userId);
        if (!$completedBooking) {
            $this->setFlashMessage('error', 'Bạn chỉ có thể đánh giá các tour đã hoàn thành');
            $this->redirect(UrlHelper::route('user/bookings'));
            return;
        }

        // Xử lý form đánh giá
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('user/review/tour/' . $id));
            return;
        }

        // Validate form data
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $review = trim($_POST['review'] ?? '');
        $title = trim($_POST['title'] ?? 'Đánh giá tour ' . $tour['title']);

        if ($rating < 1 || $rating > 5) {
            $this->setFlashMessage('error', 'Vui lòng chọn đánh giá từ 1-5 sao');
            $this->redirect(UrlHelper::route('user/review/tour/' . $id));
            return;
        }

        if (strlen($review) < 10) {
            $this->setFlashMessage('error', 'Vui lòng viết nhận xét ít nhất 10 ký tự');
            $this->redirect(UrlHelper::route('user/review/tour/' . $id));
            return;
        }

        // Kiểm tra xem đã đánh giá chưa
        $existingReview = $this->reviewsModel->getByTourAndUser($id, $userId);

        if ($existingReview) {
            // Cập nhật đánh giá hiện có
            $updateData = [
                'rating' => $rating,
                'title' => $title,
                'review' => $review,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->reviewsModel->update($existingReview['id'], $updateData);
            $message = 'Cập nhật đánh giá thành công!';
        } else {
            // Tạo đánh giá mới
            $reviewData = [
                'user_id' => $userId,
                'tour_id' => $id,
                'booking_id' => $completedBooking['id'],
                'rating' => $rating,
                'title' => $title,
                'review' => $review,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->reviewsModel->create($reviewData);
            $message = 'Đã gửi đánh giá thành công!';
        }


        if ($result) {
            // Cập nhật điểm đánh giá trung bình cho tour
            // $this->tourModel->updateAverageRating($id);

            $this->setFlashMessage('success', $message);
            $this->redirect(UrlHelper::route('home/tour-details/' . $id));
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi lưu đánh giá');
            $this->redirect(UrlHelper::route('user/review/tour/' . $id));
        }
    }
}