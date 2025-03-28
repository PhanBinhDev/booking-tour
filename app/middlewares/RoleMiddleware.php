<?php
namespace App\Middleware;

use App\Helpers\UrlHelper;

class RoleMiddleware {
    /**
     * Kiểm tra quyền truy cập
     * 
     * @param array $roles Danh sách vai trò được phép
     * @return callable
     */
    public function handle($roles = []) {
        return function() use ($roles) {
            if (!isset($_SESSION['role_id'])) {
                // Chuyển hướng đến trang đăng nhập
                header('Location: ' . UrlHelper::route('auth/login'));
                exit;
            }
            
            if (!empty($roles) && !in_array($_SESSION['role_id'], $roles)) {
                // Chuyển hướng đến trang không có quyền truy cập
                header('Location: ' . UrlHelper::route('errors/403'));
                exit;
            }
            
            return true;
        };
    }
}