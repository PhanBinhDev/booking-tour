<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\Image;

class ImageController extends BaseController {
    protected $imageModel;
    protected $itemsPerPage = 24; // Show images in a 4x6 grid
    
    public function __construct() {
        $this->imageModel = new Image();
    }
    
    /**
     * Display image gallery
     */
    public function index() {
        if (!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('/auth/login'));
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Get page number from query string
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        
        // Get search filters
        $filters = [
            'status' => $_GET['status'] ?? null,
            'folder' => $_GET['folder'] ?? null,
            'keyword' => $_GET['keyword'] ?? null
        ];
        
        // Get images based on user role and filters
        if ($currentUser['role_name'] === 'admin' || $currentUser['role_name'] === 'moderator') {
            $totalImages = count($this->imageModel->getAllWithUsers());
            $images = $this->imageModel->getAllWithUsers();
        } else {
            $totalImages = count($this->imageModel->getUserImages($currentUser['id']));
            $images = $this->imageModel->getUserImages($currentUser['id']);
        }
        
        // Apply search if keyword exists
        if (!empty($filters['keyword'])) {
            $searchFilters = [
                'status' => $filters['status'],
                'folder' => $filters['folder']
            ];
            
            if ($currentUser['role_name'] === 'user') {
                $searchFilters['user_id'] = (int)$currentUser['id'];
            }
            
            $images = $this->imageModel->search($filters['keyword'], $searchFilters);
            $totalImages = count($images);
        }
        
        // Calculate pagination
        $totalPages = ceil($totalImages / $this->itemsPerPage);
        $offset = ($page - 1) * $this->itemsPerPage;
        
        // Slice images array for current page
        $images = array_slice($images, $offset, $this->itemsPerPage);
        
        // Get image statistics
        $stats = $this->imageModel->getStats();
        
        $this->view('/admin/images/gallery', [
            'images' => $images,
            'user' => $currentUser,
            'stats' => $stats,
            'filters' => $filters,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }
    
    public function upload() {
        if(!$this->isAuthenticated()) {
            $this->redirect(UrlHelper::route('/auth/login'));
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
        //     $errors = [];
            
        //     if(empty($title)) {
        //         $errors['title'] = 'Title is required';
        //     }
            
        //     if(!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        //         $errors['image'] = 'Please select an image to upload';
        //     } else {
        //         // Kiểm tra loại file
        //         $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        //         if(!in_array($_FILES['image']['type'], $allowedTypes)) {
        //             $errors['image'] = 'Only JPG, PNG and GIF images are allowed';
        //         }
        }
            
        //     if(empty($errors)) {
        //         try {
        //             // Upload lên Cloudinary
        //             $result = CloudinaryHelper::uploadImage(
        //                 $_FILES['image']['tmp_name'],
        //                 [
        //                     'folder' => 'user_uploads',
        //                     'public_id' => uniqid('img_')
        //                 ]
        //             );
                    
        //             // Lưu thông tin vào database
        //             $imageId = $this->imageModel->create([
        //                 'title' => $title,
        //                 'description' => $description,
        //                 'file_name' => $_FILES['image']['name'],
        //                 'cloudinary_id' => $result['public_id'],
        //                 'cloudinary_url' => $result['secure_url'],
        //                 'user_id' => $currentUser['id']
        //             ]);
                    
        //             if($imageId) {
        //                 $this->redirect('/images');
        //             } else {
        //                 $errors['upload'] = 'Failed to save image information';
        //             }
        //         } catch(\Exception $e) {
        //             $errors['upload'] = 'Error uploading image: ' . $e->getMessage();
        //         }
        //     }
            
        //     $this->view('images/upload', [
        //         'errors' => $errors,
        //         'title' => $title,
        //         'description' => $description,
        //         'user' => $currentUser
        //     ]);
        // } else {
        //     $this->view('images/upload', [
        //         'user' => $currentUser
        //     ]);
        // }
    }
    
    // public function delete($id) {
    //     if(!$this->isAuthenticated()) {
    //         $this->redirect('/login');
    //     }
        
    //     $currentUser = $this->getCurrentUser();
    //     $image = $this->imageModel->getById($id);
        
    //     if(!$image) {
    //         $this->redirect('/images');
    //     }
        
    //     // Kiểm tra quyền xóa
    //     if($image['user_id'] != $currentUser['id'] && 
    //        $currentUser['role_name'] !== 'admin' && 
    //        $currentUser['role_name'] !== 'moderator') {
    //         $this->redirect('/images');
    //     }
        
    //     if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         try {
    //             // Xóa hình ảnh từ Cloudinary
    //             CloudinaryHelper::deleteImage($image['cloudinary_id']);
                
    //             // Xóa record từ database
    //             $this->imageModel->delete($id);
                
    //             $this->redirect('/images');
    //         } catch(\Exception $e) {
    //             $this->view('images/delete', [
    //                 'error' => 'Error deleting image: ' . $e->getMessage(),
    //                 'image' => $image,
    //                 'user' => $currentUser
    //             ]);
    //         }
    //     } else {
    //         $this->view('images/delete', [
    //             'image' => $image,
    //             'user' => $currentUser
    //         ]);
    //     }
    // }
}