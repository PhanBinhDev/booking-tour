<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\CloudinaryHelper;
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

        
        $currentUser = $this->getCurrentUser();
        $errors = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $alt = $_POST['alt_text'] ?? '';
            $category = $_POST['category'] ?? '';
            $errors = [];
            
            // Lưu dữ liệu đã nhập để không mất nếu có lỗi
            $formData = [
                'title' => $title,
                'description' => $description,
                'alt' => $alt,
                'category' => $category
            ];
            
            if(empty($title)) {
                $errors['title'] = 'Title is required';
            }

            if(empty($description)) {
                $errors['description'] = 'Description is required';
            }

            if(empty($alt)) {
                $errors['alt'] = 'Alt text is required';
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
            
            // Nếu không có lỗi, tiến hành upload
            if(empty($errors)) {
                $imageData = [
                    'title' => $title,
                    'description' => $description,
                    'alt_text' => $alt
                ];
                
                $result = CloudinaryHelper::uploadAndSave(
                    $_FILES['image']['tmp_name'],
                    $imageData,
                    $category,
                    $currentUser['id']
                );
                
                if($result) {
                    // Thông báo thành công và chuyển hướng đến trang gallery
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'message' => 'Image uploaded successfully!'
                    ];
                    $this->redirect(UrlHelper::route('/admin/images'));
                } else {
                    $errors['upload'] = 'Failed to upload image. Please try again.';
                }
            }
        } else {
            $this->setFlashMessage('error', 'Phương thức tải ảnh không hợp lệ!');
        }

        $this->redirect(UrlHelper::route('/admin/images'));
    }
}