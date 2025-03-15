<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Role;
use App\Models\Image;

class DashboardController extends BaseController {
    private $userModel;
    private $roleModel;
    protected $activityLogModel;
    private $imageModel;
    
    
    public function __construct() {
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
    }

    public function dashboard() {
        $currentUser = $this->getCurrentUser();
        
        // Lấy tổng số người dùng
        $users = $this->userModel->getAll();
        $userCount = count($users);
        
        // Lấy danh sách vai trò
        $roles = $this->roleModel->getAllWithPermissionCount();
        
        // Lấy tổng số hình ảnh
        $images = $this->imageModel->getAll();
        $imageCount = count($images);
        
        $this->view('admin/dashboard', [
            'user' => $currentUser,
            'userCount' => $userCount,
            'roles' => $roles,
            'imageCount' => $imageCount
        ]);
    }

    /**
     * Display activity logs
     */
    public function activityLogs() {
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

    public function deleteOldLogs() {
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