<?php
namespace App\Middlewares;

use App\Models\User;

class ModeratorMiddleware {
    public function handle() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $userModel = new User();
        $user = $userModel->getUserWithRole($_SESSION['user_id']);
        
        // Cho phép cả admin và moderator truy cập vào khu vực moderator
        if(!$user || ($user['role_name'] !== 'moderator' && $user['role_name'] !== 'admin')) {
            header('Location: /dashboard');
            exit;
        }
    }
}