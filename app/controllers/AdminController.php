<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Image;
use App\Middlewares\AdminMiddleware;

class AdminController extends BaseController {
    private $userModel;
    private $roleModel;
    private $imageModel;
    
    public function __construct() {
        // Áp dụng middleware để kiểm tra quyền admin
        $middleware = new AdminMiddleware();
        $middleware->handle();
        
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
    
    public function users() {
        $currentUser = $this->getCurrentUser();
        
        $users = [];
        $query = $this->userModel->getAll();
        
        foreach($query as $user) {
            // $userWithRole = $this->userModel->getUserWithRole($user['id']);
            // $users[] = $userWithRole;
        }
        
        $this->view('admin/users', [
            'user' => $currentUser,
            'users' => $users
        ]);
    }
    
    // public function editUser($id) {
    //     $currentUser = $this->getCurrentUser();
    //     $user = $this->userModel->getUserWithRole($id);
    //     $user = $this->userModel->getUserWithRole($id);
    //     $roles = $this->roleModel->getAll();
        
    //     if(!$user) {
    //         $this->redirect('/admin/users');
    //     }
        
    //     if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $username = $_POST['username'] ?? '';
    //         $email = $_POST['email'] ?? '';
    //         $roleId = $_POST['role_id'] ?? '';
    //         $newPassword = $_POST['new_password'] ?? '';
            
    //         $errors = [];
            
    //         // Kiểm tra username
    //         if(empty($username) || strlen($username) < 3) {
    //             $errors['username'] = 'Username must be at least 3 characters';
    //         } elseif($username !== $user['username']) {
    //             // Kiểm tra username đã tồn tại chưa nếu được thay đổi
    //             $existingUser = $this->userModel->findByUsername($username);
    //             if($existingUser && $existingUser['id'] != $id) {
    //                 $errors['username'] = 'Username is already taken';
    //             }
    //         }
            
    //         // Kiểm tra email
    //         if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //             $errors['email'] = 'Please enter a valid email';
    //         } elseif($email !== $user['email']) {
    //             // Kiểm tra email đã tồn tại chưa nếu được thay đổi
    //             $existingUser = $this->userModel->findByEmail($email);
    //             if($existingUser && $existingUser['id'] != $id) {
    //                 $errors['email'] = 'Email is already registered';
    //             }
    //         }
            
    //         // Kiểm tra role_id
    //         if(empty($roleId)) {
    //             $errors['role_id'] = 'Role is required';
    //         }
            
    //         // Kiểm tra mật khẩu mới nếu được cung cấp
    //         if(!empty($newPassword) && strlen($newPassword) < 6) {
    //             $errors['new_password'] = 'New password must be at least 6 characters';
    //         }
            
    //         if(empty($errors)) {
    //             $userData = [
    //                 'username' => $username,
    //                 'email' => $email,
    //                 'role_id' => $roleId
    //             ];
                
    //             if(!empty($newPassword)) {
    //                 $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
    //             }
                
    //             if($this->userModel->update($id, $userData)) {
    //                 $this->redirect('/admin/users?success=1');
    //             } else {
    //                 $errors['update'] = 'Failed to update user';
    //             }
    //         }
            
    //         $this->view('admin/edit_user', [
    //             'user' => $currentUser,
    //             'editUser' => $user,
    //             'roles' => $roles,
    //             'errors' => $errors
    //         ]);
    //     } else {
    //         $this->view('admin/edit_user', [
    //             'user' => $currentUser,
    //             'editUser' => $user,
    //             'roles' => $roles
    //         ]);
    //     }
    // }
    
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