<?php
namespace App\Controllers;

use App\Helpers\LayoutHelper;
use App\Helpers\SessionHelper;
use App\Helpers\UrlHelper;

class BaseController {
    public function view($view, $data = []) {
        // Thiết lập layout mặc định nếu không được chỉ định
        $layout = LayoutHelper::getLayoutByRole();

        // Trích xuất dữ liệu thành các biến riêng lẻ
        extract($data);
        
        $viewPath = ROOT_PATH . '/app/views/' . $view . '.php';

        // Bắt đầu output buffering để capture nội dung view
        ob_start();
        if(file_exists($viewPath)) {
            require $viewPath;
        } else {
            // Nếu view không tồn tại, hiển thị trang not found
            include ROOT_PATH . '/app/views/errors/404.php';
        }
        $content = ob_get_clean();
        
        if(!file_exists($layout)) {
            die("Layout not found at {$layout}");
        }

        // Load layout với nội dung từ view
        require $layout;
    }
    
    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    public function redirectByRole() {
        $redirectUrl = $this->getRouteByRole();
        $this->redirect($redirectUrl);
    }

    public function getRouteByRole() {
        $role = SessionHelper::get('role') ?? 'user';
        switch ($role) {
            case 'admin':
                return UrlHelper::route('admin/dashboard');
            case 'moderator':
                return UrlHelper::route('moderator/dashboard');
            case 'user':
            default:
                return UrlHelper::route('');
        }
    }
    
    public function json($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
    
    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }
    
    public function getCurrentUser() {
        if(isset($_SESSION['user_id'])) {
            $userModel = new \App\Models\User();
            // return $userModel->getUserWithRole($_SESSION['user_id']);
        }
        return null;
    }
    
    public function checkPermission($permission) {
        if(!$this->isAuthenticated()) {
            return false;
        }
        
        $userModel = new \App\Models\User();
        // return $userModel->hasPermission($_SESSION['user_id'], $permission);
    }

    public function getRole() {
        return SessionHelper::get('role') ?? 'user';
    }
}