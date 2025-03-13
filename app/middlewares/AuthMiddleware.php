<?php
namespace App\Middleware;

use App\Helpers\UrlHelper;

class AuthMiddleware {
    /**
     * Kiểm tra xác thực
     * 
     * @param callable $next Hàm tiếp theo
     * @return callable
     */
    public function handle($next) {
        return function() use ($next) {
            if (!isset($_SESSION['user_id'])) {
                // Lưu URL hiện tại để chuyển hướng sau khi đăng nhập
                $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
                
                // Chuyển hướng đến trang đăng nhập
                header('Location: ' . UrlHelper::route('auth/login'));
                exit;
            }
            
            return $next();
        };
    }
}