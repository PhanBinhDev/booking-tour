<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\User;
use App\Models\Role;
use App\Models\Image;
use App\Models\Location;
use App\Models\NewsModel;
use App\Models\Payment;
use App\Models\Tour;

class DashboardController extends BaseController
{
    private $userModel;
    private $roleModel;
    protected $activityLogModel;
    private $imageModel;
    protected $paymentModel;
    protected $tourModel;
    protected $bookingModel;
    protected $locationModel;
    protected $newsModel;


    public function __construct()
    {
        // // Áp dụng middleware để kiểm tra quyền admin
        $route = $this->getRouteByRole();
        $roleBase = 'admin';
        $role = $this->getRole();
        if ($role !== $roleBase) {
            $this->redirect($route);
        }

        $this->userModel = new User();
        $this->roleModel = new Role();
        $this->imageModel = new Image();
        $this->activityLogModel = new ActivityLog();
        $this->paymentModel = new Payment();
        $this->tourModel = new Tour();
        $this->bookingModel = new Booking();
        $this->locationModel = new Location();
        $this->newsModel = new NewsModel();
    }

    public function dashboard()
    {
        // if(!$this->checkPermission(PERM_VIEW_DASHBOARD)) {
        //     $this->setFlashMessage('error', 'Bạn không có quyền truy cập trang này');
        //     $this->view('error/403');
        //     return;
        // }

        $currentUser = $this->getCurrentUser();

        // Lấy năm từ request hoặc sử dụng năm hiện tại
        $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

        // Tạo danh sách các năm để hiển thị trong dropdown (từ năm đầu tiên có dữ liệu đến năm hiện tại)
        $currentYear = (int)date('Y');
        $startYear = $this->paymentModel->getFirstTransactionYear() ?: $currentYear - 2; // Mặc định 2 năm trước nếu không có dữ liệu
        $years = range($startYear, $currentYear);

        // Lấy tổng số người dùng
        $users = $this->userModel->getAll();
        $userCount = count($users);

        // Lấy danh sách vai trò
        $roles = $this->roleModel->getAllWithPermissionCount();

        // Lấy tổng số hình ảnh
        $images = $this->imageModel->getAll();
        $imageCount = count($images);

        // Lấy tổng số tour
        $tours = $this->tourModel->getAll();
        $tourCount = count($tours);

        // Lấy tổng số đặt tour
        $bookings = $this->bookingModel->getAll();
        $bookingCount = count($bookings);

        // Tính tổng doanh thu
        $totalRevenue = 0;
        $completedPayments = $this->paymentModel->getByStatus('completed');
        foreach ($completedPayments as $payment) {
            $totalRevenue += $payment['amount'];
        }

        // tin tức
        $newsCount = $this->newsModel->count();
        $recentNews = $this->newsModel->getRecentNews(5);

        $newsViewsData = $this->newsModel->getMonthlyViewsData($selectedYear);

        // Lấy dữ liệu trạng thái đặt tour cho biểu đồ theo năm đã chọn
        $bookingStatusData = [
            'Chờ xác nhận' => $this->bookingModel->countByStatusAndYear('pending', $selectedYear),
            'Đã xác nhận' => $this->bookingModel->countByStatusAndYear('confirmed', $selectedYear),
            'Đã thanh toán' => $this->bookingModel->countByStatusAndYear('paid', $selectedYear),
            'Đã hủy' => $this->bookingModel->countByStatusAndYear('cancelled', $selectedYear),
            'Hoàn thành' => $this->bookingModel->countByStatusAndYear('completed', $selectedYear)
        ];

        // Lấy dữ liệu doanh thu theo tháng cho biểu đồ
        $monthlyRevenueData = [];
        $vietnameseMonths = [
            '1' => 'Tháng 1',
            '2' => 'Tháng 2',
            '3' => 'Tháng 3',
            '4' => 'Tháng 4',
            '5' => 'Tháng 5',
            '6' => 'Tháng 6',
            '7' => 'Tháng 7',
            '8' => 'Tháng 8',
            '9' => 'Tháng 9',
            '10' => 'Tháng 10',
            '11' => 'Tháng 11',
            '12' => 'Tháng 12'
        ];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyRevenue = $this->paymentModel->getMonthlyRevenue($selectedYear, $month);
            $monthlyRevenueData[$vietnameseMonths[$month]] = $monthlyRevenue;
        }

        // Lấy đơn đặt tour gần đây
        $recentBookings = $this->bookingModel->getRecent(5);

        // Lấy tour phổ biến (dựa trên số lượng đặt tour)
        $popularTours = $this->tourModel->getPopular(5);

        // Lấy địa điểm phổ biến (dựa trên số lượng tour)
        $popularLocations = $this->locationModel->getPopular(6);

        $this->view('admin/dashboard', [
            'user' => $currentUser,
            'userCount' => $userCount,
            'roles' => $roles,
            'imageCount' => $imageCount,
            'tourCount' => $tourCount,
            'bookingCount' => $bookingCount,
            'totalRevenue' => $totalRevenue,
            'bookingStatusData' => $bookingStatusData,
            'monthlyRevenueData' => $monthlyRevenueData,
            'recentBookings' => $recentBookings,
            'popularTours' => $popularTours,
            'popularLocations' => $popularLocations,
            'selectedYear' => $selectedYear,
            'years' => $years,
            'newsCount' => $newsCount,
            'recentNews' => $recentNews,
            'newsViewsData' => $newsViewsData
        ]);
    }



    /**
     * Display activity logs
     */
    public function activityLogs()
    {
        // Get page and limit from request
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

        // Build filters array
        $filters = [];

        if (!empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }

        if (!empty($_GET['entity_type'])) {
            $filters['entity_type'] = $_GET['entity_type'];
        }

        if (!empty($_GET['entity_id'])) {
            $filters['entity_id'] = $_GET['entity_id'];
        }

        if (!empty($_GET['user_id'])) {
            $filters['user_id'] = $_GET['user_id'];
        }

        if (!empty($_GET['date_from'])) {
            $filters['date_from'] = $_GET['date_from'];
        }

        if (!empty($_GET['date_to'])) {
            $filters['date_to'] = $_GET['date_to'];
        }

        // Get paginated logs
        $logs = $this->activityLogModel->getPaginated($page, $limit, $filters);

        // Get users for filter dropdown
        $users = $this->userModel->getAll();

        // Load view
        $this->view('admin/system/activity-logs', [
            'logs' => $logs,
            'filters' => $filters,
            'users' => $users
        ]);
    }

    public function deleteOldLogs()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(UrlHelper::route('admin/system/activity-logs'));
        }

        // Get days to keep from request
        $days = isset($_POST['days']) ? (int)$_POST['days'] : 90;

        // Delete old logs
        $success = $this->activityLogModel->deleteOldLogs($days);

        if ($success) {
            $this->setFlashMessage('success', 'Đã xóa nhật ký cũ thành công');
        } else {
            $this->setFlashMessage('error', 'Không thể xóa nhật ký cũ');
        }

        $this->redirect(UrlHelper::route('admin/system/activity-logs'));
    }
}
