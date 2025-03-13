<?php
namespace App\Middlewares;

class AuthMiddleware {
    public function handle() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}