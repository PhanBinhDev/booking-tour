<?php
namespace App\Controllers;

class BaseController {
    public function view($view, $data = []) {
        extract($data);
        
        $viewPath = ROOT_PATH . '/app/views/' . $view . '.php';
        
        if(file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View {$view} not found");
        }
    }
    
    public function redirect($url) {
        header('Location: ' . $url);
        exit;
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
            return $userModel->getUserWithRole($_SESSION['user_id']);
        }
        return null;
    }
    
    public function checkPermission($permission) {
        if(!$this->isAuthenticated()) {
            return false;
        }
        
        $userModel = new \App\Models\User();
        return $userModel->hasPermission($_SESSION['user_id'], $permission);
    }
}