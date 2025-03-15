<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Role;
use App\Models\Image;

class DashboardController extends BaseController {
    private $userModel;
    private $roleModel;
    private $imageModel;
    
    public function __construct() {
        // // Áp dụng middleware để kiểm tra quyền admin
        // $route = $this->getRouteByRole();
        // $roleBase = 'admin';
        // $role = $this->getRole();
        // if ($role !== $roleBase) {
        //     $this->redirect($route);
        // }

        $this->userModel = new User();
        $this->roleModel = new Role();
        $this->imageModel = new Image();
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
}