<?php
namespace App\Controllers;

use App\Models\Image;
use App\Helpers\CloudinaryHelper;
use App\Config\Cloudinary;

class ImageController extends BaseController {
    private $imageModel;
    
    public function __construct() {
        $this->imageModel = new Image();
        
        // Thiết lập Cloudinary
        Cloudinary::setup();
    }
    
    public function index() {
        if(!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
        
        $currentUser = $this->getCurrentUser();
        $images = [];
        
        // Admin và Moderator xem tất cả hình ảnh, User chỉ xem hình của mình
        if($currentUser['role_name'] === 'admin' || $currentUser['role_name'] === 'moderator') {
            $images = $this->imageModel->getAllWithUsers();
        } else {
            $images = $this->imageModel->getUserImages($currentUser['id']);
        }
        
        $this->view('images/gallery', [
            'images' => $images,
            'user' => $currentUser
        ]);
    }
    
    public function upload() {
        if(!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
        
        if(!$this->checkPermission('upload_images')) {
            $this->redirect('/dashboard');
        }
        
        $currentUser = $this->getCurrentUser();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $errors = [];
            
            if(empty($title)) {
                $errors['title'] = 'Title is required';
            }
            
            if(!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $errors['image'] = 'Please select an image to upload';
            } else {
                // Kiểm tra loại file
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if(!in_array($_FILES['image']['type'], $allowedTypes)) {
                    $errors['image'] = 'Only JPG, PNG and GIF images are allowed';
                }
            }
            
            if(empty($errors)) {
                try {
                    // Upload lên Cloudinary
                    $result = CloudinaryHelper::uploadImage(
                        $_FILES['image']['tmp_name'],
                        [
                            'folder' => 'user_uploads',
                            'public_id' => uniqid('img_')
                        ]
                    );
                    
                    // Lưu thông tin vào database
                    $imageId = $this->imageModel->create([
                        'title' => $title,
                        'description' => $description,
                        'file_name' => $_FILES['image']['name'],
                        'cloudinary_id' => $result['public_id'],
                        'cloudinary_url' => $result['secure_url'],
                        'user_id' => $currentUser['id']
                    ]);
                    
                    if($imageId) {
                        $this->redirect('/images');
                    } else {
                        $errors['upload'] = 'Failed to save image information';
                    }
                } catch(\Exception $e) {
                    $errors['upload'] = 'Error uploading image: ' . $e->getMessage();
                }
            }
            
            $this->view('images/upload', [
                'errors' => $errors,
                'title' => $title,
                'description' => $description,
                'user' => $currentUser
            ]);
        } else {
            $this->view('images/upload', [
                'user' => $currentUser
            ]);
        }
    }
    
    public function delete($id) {
        if(!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
        
        $currentUser = $this->getCurrentUser();
        $image = $this->imageModel->getById($id);
        
        if(!$image) {
            $this->redirect('/images');
        }
        
        // Kiểm tra quyền xóa
        if($image['user_id'] != $currentUser['id'] && 
           $currentUser['role_name'] !== 'admin' && 
           $currentUser['role_name'] !== 'moderator') {
            $this->redirect('/images');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Xóa hình ảnh từ Cloudinary
                CloudinaryHelper::deleteImage($image['cloudinary_id']);
                
                // Xóa record từ database
                $this->imageModel->delete($id);
                
                $this->redirect('/images');
            } catch(\Exception $e) {
                $this->view('images/delete', [
                    'error' => 'Error deleting image: ' . $e->getMessage(),
                    'image' => $image,
                    'user' => $currentUser
                ]);
            }
        } else {
            $this->view('images/delete', [
                'image' => $image,
                'user' => $currentUser
            ]);
        }
    }
}