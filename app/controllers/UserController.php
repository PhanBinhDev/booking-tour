<?php

namespace App\Controllers;

use App\Helpers\UrlHelper;
use App\Models\User;


class UserController extends BaseController { 
    private $userModel;

    public function __construct()
    {

    
    public function __construct() {
        $this->userModel = new User();

    }

    public function dashboard()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('auth/login'));
        }

        $currentUser = $this->getCurrentUser();

       
        // Chuyển hướng dựa vào vai trò
        if ($currentUser['role_name'] === 'admin') {
            $this->redirect(UrlHelper::route('admin/dashboard'));
        } elseif ($currentUser['role_name'] === 'moderator') {
            $this->redirect(UrlHelper::route('moderator/dashboard'));
        }

        $this->view('user/dashboard', [
            'user' => $currentUser,
            
        ]);
    }

    public function profile()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('auth/login'));
        }

        $currentUser = $this->getCurrentUser();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $errors = [];

            // Kiểm tra username
            if (empty($username) || strlen($username) < 3) {
                $errors['username'] = 'Username must be at least 3 characters';
            } elseif ($username !== $currentUser['username']) {
                // Kiểm tra username đã tồn tại chưa nếu được thay đổi
                $existingUser = $this->userModel->findByUsername($username);
                if ($existingUser && $existingUser['id'] != $currentUser['id']) {
                    $errors['username'] = 'Username is already taken';
                }
            }

            // Kiểm tra email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter a valid email';
            } elseif ($email !== $currentUser['email']) {
                // Kiểm tra email đã tồn tại chưa nếu được thay đổi
                $existingUser = $this->userModel->findByEmail($email);
                if ($existingUser && $existingUser['id'] != $currentUser['id']) {
                    $errors['email'] = 'Email is already registered';
                }
            }

            // Nếu đang cập nhật mật khẩu
            $updatingPassword = !empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword);

            if ($updatingPassword) {
                if (empty($currentPassword)) {
                    $errors['current_password'] = 'Current password is required';
                } elseif (!password_verify($currentPassword, $currentUser['password'])) {
                    $errors['current_password'] = 'Current password is incorrect';
                }

                if (empty($newPassword) || strlen($newPassword) < 6) {
                    $errors['new_password'] = 'New password must be at least 6 characters';
                }

                if ($newPassword !== $confirmPassword) {
                    $errors['confirm_password'] = 'Passwords do not match';
                }
            }

            if (empty($errors)) {
                $userData = [
                    'username' => $username,
                    'email' => $email
                ];

                if ($updatingPassword) {
                    $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                }

                if ($this->userModel->update($currentUser['id'], $userData)) {
                    $_SESSION['username'] = $username;
                    $this->redirect(UrlHelper::route('user/profile?success=1'));
                    $this->setFlashMessage('success', 'message');
                } else {
                    $errors['update'] = 'Failed to update profile';
                }
            }

            $this->view('user/profile', [
                'user' => $currentUser,
                'errors' => $errors
            ]);
        } else {
            $this->view('user/profile', [
                'user' => $currentUser,
                'success' => isset($_GET['success'])
            ]);
        }
        $userProfile= $this->userModel->getUserProfile($currentUser['id']);

        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $date_of_birth = $_POST['date_of_birth'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $date_of_birth = $_POST['date_of_birth'] ?? ''; 
            $bio = $_POST['bio'] ?? ''; 
            $website = $_POST['website'] ?? ''; 
            $facebook = $_POST['facebook'] ?? ''; 
            $twitter = $_POST['twitter'] ?? ''; 
            $instagram = $_POST['instagram'] ?? ''; 

            $data = [
                'full_name' => $full_name,
                'phone' => $phone,
                'gender'=> $gender,
                'address'=> $address,
                'date_of_birth' => $date_of_birth,
                'bio' => $bio,
                'website' => $website,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'instagram' => $instagram,
                'user_id' => $currentUser['id']
            ];

        

            $this->userModel->updateProfile($data);
            
        }
        $this->view('user/profile',["currentUser"=>$currentUser, "userProfile"=>$userProfile]);


        
        



          
        //     $profile['date_of_birth'] = $_POST['date_of_birth'] ?? $profile['date_of_birth'] ?? '';
        //     $profile['gender'] = $_POST['gender'] ?? $profile['gender'] ?? '';
        //     $profile['website'] = $_POST['website'] ?? $profile['website'] ?? '';
        //     $profile['facebook'] = $_POST['facebook'] ?? $profile['facebook'] ?? '';
        //     $profile['twitter'] = $_POST['twitter'] ?? $profile['twitter'] ?? '';
        //     $currentPassword = $_POST['current_password'] ?? '';
        //     $newPassword = $_POST['new_password'] ?? '';
        //     $confirmPassword = $_POST['confirm_password'] ?? '';
            
        //     $errors = [];
            
        //     // Kiểm tra username
        //     if(empty($username) || strlen($username) < 3) {
        //         $errors['username'] = 'Username must be at least 3 characters';
        //     } elseif($username !== $currentUser['username']) {
        //         // Kiểm tra username đã tồn tại chưa nếu được thay đổi
        //         $existingUser = $this->userModel->findByUsername($username);
        //         if($existingUser && $existingUser['id'] != $currentUser['id']) {
        //             $errors['username'] = 'Username is already taken';
        //         }
        //     }
            
        //     // Kiểm tra email
        //     if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //         $errors['email'] = 'Please enter a valid email';
        //     } elseif($email !== $currentUser['email']) {
        //         // Kiểm tra email đã tồn tại chưa nếu được thay đổi
        //         $existingUser = $this->userModel->findByEmail($email);
        //         if($existingUser && $existingUser['id'] != $currentUser['id']) {
        //             $errors['email'] = 'Email is already registered';
        //         }
        //     }
            
        //     // Nếu đang cập nhật mật khẩu
        //     $updatingPassword = !empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword);
            
        //     if($updatingPassword) {
        //         if(empty($currentPassword)) {
        //             $errors['current_password'] = 'Current password is required';
        //         } elseif(!password_verify($currentPassword, $currentUser['password'])) {
        //             $errors['current_password'] = 'Current password is incorrect';
        //         }
                
        //         if(empty($newPassword) || strlen($newPassword) < 6) {
        //             $errors['new_password'] = 'New password must be at least 6 characters';
        //         }
                
        //         if($newPassword !== $confirmPassword) {
        //             $errors['confirm_password'] = 'Passwords do not match';
        //         }
        //     }

            
            
        //     if(empty($errors)) {
        //         $userData = [
        //             'username' => $username,
        //             'email' => $email,
        //             'date_of_birth' => $date_of_birth,

        //         ];
                
        //         if($updatingPassword) {
        //             $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        //         }
                
        //         if($this->userModel->update($currentUser['id'], $userData)) {
        //             $_SESSION['username'] = $username;
        //             $this->redirect(UrlHelper::route('user/profile?success=1'));
        //             $this->setFlashMessage('success', 'message');
        //         } else {
        //             $errors['update'] = 'Failed to update profile';
        //         }
        //     }
            
        //     $this->view('user/profile', [
        //         'user' => $currentUser,
        //         'errors' => $errors
        //     ]);
        // } else {
        //     $this->view('user/profile', [
        //         'user' => $currentUser,
        //         'success' => isset($_GET['success'])
        //     ]);
        // }
    }

    public function changePassword()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('auth/login'));
        }

        $this->view('user/change-password');
    }

    public function userBookings()
    {
        $this->view('user/user-bookings');
    }
}
