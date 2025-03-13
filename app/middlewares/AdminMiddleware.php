<?php
namespace App\Middlewares;

use App\Models\User;

class AdminMiddleware {
    public function handle() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $userModel = new User();
        $user = '';
        
        if(!$user || $user['role_name'] !== 'admin') {
            header('Location: /dashboard');
            exit;
        }
    }
}