<?php
namespace App\Controllers;

use App\Models\User;
use App\Helpers\Validator;

class AuthController extends BaseController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        if($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $errors = [];
            
            if(empty($email)) {
                $errors['email'] = 'Email is required';
            }
            
            if(empty($password)) {
                $errors['password'] = 'Password is required';
            }
            
            if(empty($errors)) {
                $user = $this->userModel->authenticate($email, $password);
                
                if($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role_id'] = $user['role_id'];
                    
                    $this->redirect('/dashboard');
                } else {
                    $errors['login'] = 'Invalid email or password';
                }
            }
            
            $this->view('auth/login', [
                'errors' => $errors,
                'email' => $email
            ]);
        } else {
            $this->view('auth/login');
        }
    }
    
    public function register() {
        if($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';
            
            $errors = [];
            
            // Kiểm tra đầu vào
            if(empty($username) || strlen($username) < 3) {
                $errors['username'] = 'Username must be at least 3 characters';
            }
            
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter a valid email';
            }
            
            if(empty($password) || strlen($password) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            }
            
            if($password !== $passwordConfirm) {
                $errors['password_confirm'] = 'Passwords do not match';
            }
            
            // Kiểm tra email và username đã tồn tại chưa
            if(empty($errors['email']) && $this->userModel->findByEmail($email)) {
                $errors['email'] = 'Email is already registered';
            }
            
            if(empty($errors['username']) && $this->userModel->findByUsername($username)) {
                $errors['username'] = 'Username is already taken';
            }
            
            if(empty($errors)) {
                $userId = $this->userModel->create([
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role_id' => 3  // Default role_id for regular users
                ]);
                
                if($userId) {
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['username'] = $username;
                    $_SESSION['role_id'] = 3;
                    
                    $this->redirect('/dashboard');
                } else {
                    $errors['register'] = 'Registration failed. Please try again.';
                }
            }
            
            $this->view('auth/register', [
                'errors' => $errors,
                'username' => $username,
                'email' => $email
            ]);
        } else {
            $this->view('auth/register');
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}