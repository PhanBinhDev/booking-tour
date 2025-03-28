<?php
namespace App\Controllers;

use App\Models\Image;
use App\Middlewares\ModeratorMiddleware;

class ModeratorController extends BaseController {
    private $imageModel;
    
    public function __construct() {
        // Áp dụng middleware để kiểm tra quyền moderator
        $route = $this->getRouteByRole();
        $roleBase = 'moderator';
        $role = $this->getRole();
        if ($role !== $roleBase) {
            $this->redirect($route);
        }
        
        $this->imageModel = new Image();
    }
    
    public function dashboard() {
        $currentUser = $this->getCurrentUser();
        
        // Lấy tổng số hình ảnh
        $images = $this->imageModel->getAllWithUsers();
        
        $this->view('moderator/dashboard', [
            'user' => $currentUser,
            'images' => $images,
            'imageCount' => count($images)
        ]);
    }
}