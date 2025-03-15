<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Role;

class UserController extends BaseController {
    private $userModel;
    private $roleModel;
    
    public function __construct() {
        // Áp dụng middleware để kiểm tra quyền admin
        $route = $this->getRouteByRole();
        $roleBase = 'admin';
        $role = $this->getRole();
        if ($role !== $roleBase) {
            $this->redirect($route);
        }
        
        $this->userModel = new User();
        $this->roleModel = new Role();
    }
    
    // -------------
    // Users
    // -------------
    
    public function index() {
        $currentUser = $this->getCurrentUser();
        
        $users = [];
        $query = $this->userModel->getAll();
        $roles = $this->roleModel->getAll();
        
        foreach($query as $user) {
            $userWithRole = $this->userModel->getUserWithRole($user['id']);
            $users[] = $userWithRole;
        }
        
        $this->view('admin/users/index', [
            'user' => $currentUser,
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function edit($id) {
        $currentUser = $this->userModel->findById($id);
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 'EDIT';
            // EDIT TRRONG NÀY
        } else {
            $this->view('admin/users/edit', [
                'user' => $currentUser,
            ]);
        }

    }
    
    public function deleteUser($id) {
        $currentUser = $this->getCurrentUser();
        
        // Không cho phép xóa chính mình
        if($id == $currentUser['id']) {
            $this->redirect('/admin/users?error=cannot_delete_self');
        }
        
        $user = $this->userModel->getById($id);
        
        if(!$user) {
            $this->redirect('/admin/users');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($this->userModel->delete($id)) {
                $this->redirect('/admin/users?success=2');
            } else {
                $this->redirect('/admin/users?error=delete_failed');
            }
        } else {
            $this->view('admin/delete_user', [
                'user' => $currentUser,
                'deleteUser' => $user
            ]);
        }
    }

}