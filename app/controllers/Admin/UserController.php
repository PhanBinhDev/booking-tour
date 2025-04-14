<?php


namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;
use App\Models\Booking;
use App\Models\Reviews;
use App\Models\User;
use App\Models\Role;
use App\Models\Tour;
use Exception;

class UserController extends BaseController
{
    private $userModel;
    private $roleModel;
    private $bookingModel;
    private $reviewModel;
    private $tourModel;


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
        $this->bookingModel = new Booking();
        $this->reviewModel = new Reviews();
        $this->tourModel = new Tour();
    }


    // -------------
    // Users
    // -------------

    public function index()
    {
        $currentUser = $this->getCurrentUser();

        // Get pagination parameters from request
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = isset($_GET['limit']) ? max(1, intval($_GET['limit'])) : 10;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $roleFilter = isset($_GET['role_id']) ? intval($_GET['role_id']) : null;
        $statusFilter = isset($_GET['status']) ? trim($_GET['status']) : null;
        $sortField = isset($_GET['sort']) ? trim($_GET['sort']) : 'created_at';
        $sortDirection = isset($_GET['direction']) && strtolower($_GET['direction']) === 'asc' ? 'asc' : 'desc';

        // Build pagination options
        $options = [
            'columns' => 'users.*, roles.name as role_name',
            'joins' => [
                'LEFT JOIN roles ON users.role_id = roles.id'
            ],
            'filters' => [],
            'sort' => $sortField,
            'direction' => $sortDirection,
            'page' => $page,
            'limit' => $limit,
            'search_fields' => ['users.username', 'users.email', 'users.full_name'],
            'table_alias' => 'users'
        ];

        // Add search term if provided
        if (!empty($search)) {
            $options['search_term'] = "%$search%";
        }

        // Add role filter if provided
        if (!empty($roleFilter)) {
            $options['filters']['users.role_id'] = $roleFilter;
        }

        // Add status filter if provided
        if (!empty($statusFilter)) {
            $options['filters']['users.status'] = $statusFilter;
        }

        // Get paginated users with their roles
        $paginatedUsers = $this->userModel->getPaginatedCustom($options);

        // Get all roles for filter dropdown
        $roles = $this->roleModel->getAll();

        // Filter parameters to pass to the view (for maintaining state in pagination links)
        $filters = [
            'search' => $search,
            'role_id' => $roleFilter,
            'status' => $statusFilter,
            'sort' => $sortField,
            'direction' => $sortDirection
        ];

        $this->view('admin/users/index', [
            'user' => $currentUser,
            'users' => $paginatedUsers['items'],
            'pagination' => $paginatedUsers['pagination'],
            'roles' => $roles,
            'filters' => $filters
        ]);
    }


    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $full_name = trim($_POST['full_name']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = intval($_POST['role']); // Đảm bảo role là số
            $status = trim($_POST['status']);
            $avatar = '';

            $errors = [];

            // Validate inputs
            if (empty($username) || strlen($username) < 6) {
                $errors['username'] = 'Tên người dùng phải có ít nhất 6 ký tự';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Vui lòng nhập email hợp lệ';
            } elseif ($this->userModel->findByEmail($email)) {
                $errors['email'] = 'Email này đã được sử dụng';
            }

            // Handle file upload

            $data = [
                'username' => $username,
                'email' => $email,
                'full_name' => $full_name,
                'password' => $password,
                'role_id' => $role,
                'status' => $status,
                'avatar' => $avatar
            ];

            $this->userModel->create($data); // Đảm bảo truyền đúng kiểu dữ liệu
            $this->setFlashMessage('success', 'Tạo người dùng thanh cong');
            header('Location:' . UrlHelper::route('/admin/users/index'));
            exit;
            // Trả lại view với lỗi và dữ liệu nhập trước đó
            $this->view('admin/users/create', [
                'errors' => $errors,
                'input' => $_POST
            ]);
        } else {
            // Lấy danh sách roles (nếu cần)
            $roles = $this->userModel->getAll();

            // Hiển thị form tạo người dùng
            $this->view('admin/users/create', [
                'roles' => $roles
            ]);
        }
    }

    public function edit($id)
    {
        $currentUser = $this->userModel->findById($id);
        $roles = $this->roleModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $full_name = trim($_POST['full_name']);
            $phone = trim($_POST['phone']);
            $role_id = intval($_POST['role_id']);
            $status = trim($_POST['status']);
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

            $errors = [];

            // Validate inputs
            if (empty($username) || strlen($username) < 6) {
                $errors['username'] = 'Tên người dùng phải có ít nhất 6 ký tự';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Vui lòng nhập email hợp lệ';
            } elseif ($this->userModel->findByEmail($email) && $email !== $currentUser['email']) {
                $errors['email'] = 'Email này đã được sử dụng';
            }

            if (!empty($_POST['password']) && strlen($_POST['password']) < 8) {
                $errors['password'] = 'Mật khẩu phải có ít nhất 8 ký tự';
            }

            if (!empty($_POST['password']) && $_POST['password'] !== $_POST['password_confirm']) {
                $errors['password_confirm'] = 'Mật khẩu xác nhận không khớp';
            }

            // Xử lý upload avatar
            $avatar = $currentUser['avatar'] ?? '';

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                try {
                    // Upload ảnh lên Cloudinary và lưu thông tin
                    $uploadResult = CloudinaryHelper::upload($_FILES['avatar']['tmp_name'], 'users');

                    if (!isset($uploadResult['secure_url'])) {
                        throw new Exception('Lỗi khi upload ảnh');
                    }

                    $avatar = $uploadResult['secure_url'];
                } catch (Exception $e) {
                    $errors['avatar'] = 'Lỗi khi upload ảnh: ' . $e->getMessage();
                }
            }

            if (empty($errors)) {
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'full_name' => $full_name,
                    'phone' => $phone,
                    'role_id' => $role_id,
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($avatar)) {
                    $data['avatar'] = $avatar;
                }

                if ($password) {
                    $data['password'] = $password;
                }

                // Cập nhật người dùng
                $res = $this->userModel->update($id, $data);

                if ($res) {
                    $this->setFlashMessage('success', 'Cập nhật người dùng thành công');
                    $this->redirect(UrlHelper::route('/admin/users/index'));
                    return;
                } else {
                    $errors['general'] = 'Đã xảy ra lỗi khi cập nhật người dùng';
                }
            }

            $this->view('admin/users/edit', [
                'user' => array_merge($currentUser, $_POST),
                'roles' => $roles,
                'errors' => $errors
            ]);
        } else {
            $this->view('admin/users/edit', [
                'user' => $currentUser,
                'roles' => $roles
            ]);
        }
    }

    public function deleteUser($id)
    {
        $currentUser = $this->getCurrentUser();

        // Không cho phép xóa chính mình
        if ($id == $currentUser['id']) {
            $this->redirect(UrlHelper::route('/admin/users?error=cannot_delete_self'));
            return;
        }

        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->redirect(UrlHelper::route('/admin/users?error=user_not_found'));
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->userModel->delete($id)) {
                $this->redirect(UrlHelper::route('/admin/users?success=delete_success'));
            } else {
                $this->redirect(UrlHelper::route('/admin/users?error=delete_failed'));
            }
        } else {
            $this->view('admin/delete_user', [
                'user' => $currentUser,
                'deleteUser' => $user
            ]);
        }
    }

    /**
     * Hiển thị chi tiết người dùng
     * 
     * @param int $id ID của người dùng
     * @return void
     */
    public function detail($id)
    {
        // Kiểm tra quyền admin
        // if (!$this->checkAdminRole()) {
        //     $this->redirect(UrlHelper::route('auth/login'));
        //     return;
        // }

        // Lấy thông tin chi tiết người dùng
        $user = $this->userModel->getUserWithRole($id);

        if (!$user) {
            $this->setFlashMessage('error', 'Không tìm thấy thông tin người dùng');
            $this->redirect(UrlHelper::route('admin/users'));
            return;
        }

        // Lấy thêm các thông tin thống kê
        $stats = [
            'total_bookings' => $this->bookingModel->countUserBookings($id),
            'completed_bookings' => $this->bookingModel->countUserBookingsByStatus($id, 'completed'),
            'review_count' => $this->reviewModel->countUserReviews($id),
            'average_rating' => $this->reviewModel->getUserAverageRating($id)
        ];

        // Lấy đơn đặt tour gần đây
        $recentBookings = $this->bookingModel->getRecentUserBookings($id, 5);

        // Lấy đánh giá gần đây
        $recentReviews = $this->reviewModel->getRecentUserReviews($id, 5);

        $user['stats'] = $stats;
        $user['recent_bookings'] = $recentBookings;
        $user['recent_reviews'] = $recentReviews;

        // Hiển thị trang chi tiết
        $this->view('admin/users/details', [
            'user' => $user
        ]);
    }

    /**
     * Cập nhật trạng thái người dùng
     * 
     * @return void
     */
    public function updateStatus()
    {
        // Kiểm tra quyền admin
        if (!$this->isAdmin()) {
            $this->json(['success' => false, 'message' => 'Không có quyền truy cập'], 403);
            return;
        }

        // Kiểm tra phương thức request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Phương thức không được hỗ trợ'], 405);
            return;
        }

        // Lấy dữ liệu
        $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        // Kiểm tra dữ liệu
        if ($userId <= 0) {
            $this->json(['success' => false, 'message' => 'ID người dùng không hợp lệ'], 400);
            return;
        }

        // Kiểm tra trạng thái hợp lệ
        $validStatuses = ['active', 'inactive', 'banned'];
        if (!in_array($status, $validStatuses)) {
            $this->json(['success' => false, 'message' => 'Trạng thái không hợp lệ'], 400);
            return;
        }

        // Kiểm tra người dùng tồn tại
        $user = $this->userModel->findById($userId);
        if (!$user) {
            $this->json(['success' => false, 'message' => 'Không tìm thấy người dùng'], 404);
            return;
        }

        // Không thể thay đổi trạng thái của chính mình
        if ($userId == $_SESSION['user_id']) {
            $this->json(['success' => false, 'message' => 'Bạn không thể thay đổi trạng thái của chính mình'], 403);
            return;
        }

        // Cập nhật trạng thái
        $result = $this->userModel->update($userId, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($result) {
            $this->json(['success' => true, 'message' => 'Cập nhật trạng thái người dùng thành công']);
        } else {
            $this->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi cập nhật trạng thái người dùng'], 500);
        }
    }
}
