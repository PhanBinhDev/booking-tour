<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\CloudinaryHelper;
use App\Models\Image;
use App\Helpers\UrlHelper;

class ImageController extends BaseController
{
    private $imageModel;
    protected $itemsPerPage = 24;

    public function __construct()
    {
        $this->imageModel = new Image();
    }

    /**
     * Display image gallery
     */
    public function index()
    {
        $currentUser = $this->getCurrentUser();

        // Get page number from query string
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

        // Get search filters
        $filters = [
            'status' => $_GET['status'] ?? null,
            'category' => $_GET['category'] ?? null,
            'keyword' => $_GET['keyword'] ?? null
        ];

        $hasFilters = !empty($filters['keyword']) || !empty($filters['category']) ||
            (isset($filters['status']) && $filters['status'] !== null);

        // Prepare search filters
        $searchFilters = [
            'status' => $filters['status'],
            'category' => $filters['category']
        ];

        // Add user_id filter if user role is not admin/moderator
        if ($currentUser['role_name'] === 'user') {
            $searchFilters['user_id'] = (int)$currentUser['id'];
        }

        // Apply filters or get all images
        if ($hasFilters) {
            // Use search with or without keyword
            $images = $this->imageModel->search($filters['keyword'] ?? '', $searchFilters);
        } else {
            // No filters - get all images based on user role
            if ($currentUser['role_name'] === 'admin' || $currentUser['role_name'] === 'moderator') {
                $images = $this->imageModel->getAllWithUsers();
            } else {
                $images = $this->imageModel->getUserImages($currentUser['id']);
            }
        }

        // Get total count for pagination
        $totalImages = count($images);

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

    /**
     * Xử lý tải lên hình ảnh
     */
    public function upload()
    {
        $currentUser = $this->getCurrentUser();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $alt = $_POST['alt_text'] ?? '';
            $category = $_POST['category'] ?? '';
            $errors = [];


            if (empty($title)) {
                $errors['title'] = 'Title is required';
            }

            if (empty($description)) {
                $errors['description'] = 'Description is required';
            }

            if (empty($alt)) {
                $errors['alt'] = 'Alt text is required';
            }

            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $errors['image'] = 'Please select an image to upload';
            } else {
                // Kiểm tra loại file
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                    $errors['image'] = 'Only JPG, PNG and GIF images are allowed';
                }
            }

            // Nếu không có lỗi, tiến hành upload
            if (empty($errors)) {
                $imageData = [
                    'title' => $title,
                    'description' => $description,
                    'alt_text' => $alt,
                    'category' => $category,
                    'user_id' => $currentUser['id']
                ];

                $result = CloudinaryHelper::uploadAndSave(
                    $_FILES['image']['tmp_name'],
                    $imageData,
                    $category,
                    $currentUser['id']
                );

                if ($result) {
                    $this->setFlashMessage('success', 'Upload ảnh thành công');
                    $this->redirect(UrlHelper::route('/admin/images'));
                } else {
                    $this->setFlashMessage('error', 'Không thể tải ảnh lên. Vui lòng thử lại sau.');
                }
            }
        } else {
            $this->setFlashMessage('error', 'Phương thức tải ảnh không hợp lệ!');
        }

        $this->redirect(UrlHelper::route('/admin/images'));
    }

    /**
     * Xử lý xóa hình ảnh
     */
    public function delete($id)
    {
        // if (!$this->checkPermission(PERM_DELETE_IMAGES)) {
        //     $this->setFlashMessage('error', 'Bạn không có quyền xóa hình ảnh');
        //     $this->view('error/403');
        //     return;
        // }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setFlashMessage('error', 'Phương thức không hợp lệ');
            $this->redirect(UrlHelper::route('/admin/images'));
            return;
        }

        if (!$id) {
            $this->setFlashMessage('error', 'ID hình ảnh không hợp lệ');
            $this->redirect(UrlHelper::route('/admin/images'));
            return;
        }

        // Sử dụng phương thức deleteById đã cải tiến
        $result = CloudinaryHelper::deleteById($id);

        if ($result) {
            $this->setFlashMessage('success', 'Xóa hình ảnh thành công');
        } else {
            $this->setFlashMessage('error', 'Không thể xóa hình ảnh. Vui lòng thử lại sau.');
        }

        $this->redirect(UrlHelper::route('/admin/images'));
    }

    /**
     * Xử lý cập nhật thông tin hình ảnh
     */
    public function update($id)
    {
        // if(!$this->checkPermission(PERM_EDIT_IMAGES)) {
        //     $this->setFlashMessage('error', 'Bạn không có quyền chỉnh sửa hình ảnh');
        //     $this->view('error/403');
        //     return;
        // }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setFlashMessage('error', 'Phương thức không hợp lệ');
            $this->redirect(UrlHelper::route('/admin/images'));
            return;
        }

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $altText = $_POST['alt_text'] ?? '';
        $category = $_POST['category'] ?? '';

        if (!$id) {
            $this->setFlashMessage('error', 'ID hình ảnh không hợp lệ');
            $this->redirect(UrlHelper::route('/admin/images'));
            return;
        }

        if (empty($title)) {
            $this->setFlashMessage('error', 'Tiêu đề không được để trống');
            $this->redirect(UrlHelper::route('/admin/images/edit/' . $id));
            return;
        }

        $data = [
            'title' => $title,
            'description' => $description,
            'alt_text' => $altText,
            'category' => $category,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Sử dụng phương thức update đã cải tiến
        $result = CloudinaryHelper::updateImage($id, $data);

        if ($result) {
            $this->setFlashMessage('success', 'Cập nhật thông tin hình ảnh thành công');
            $this->redirect(UrlHelper::route('/admin/images'));
        } else {
            $this->setFlashMessage('error', 'Không thể cập nhật thông tin hình ảnh. Vui lòng thử lại sau.');
            $this->redirect(UrlHelper::route('/admin/images/edit/' . $id));
        }
    }

    /**
     * Hiển thị trang chỉnh sửa hình ảnh
     */
    public function edit($id)
    {
        // if(!$this->checkPermission(PERM_EDIT_IMAGES)) {
        //     $this->setFlashMessage('error', 'Bạn không có quyền chỉnh sửa hình ảnh');
        //     $this->view('error/403');
        //     return;
        // }

        $image = $this->imageModel->getById($id);

        if (!$image) {
            $this->setFlashMessage('error', 'Không tìm thấy hình ảnh');
            $this->redirect(UrlHelper::route('/admin/images'));
            return;
        }

        $this->view('admin/images/edit', [
            'image' => $image,
            'activePage' => 'images',
            'pageTitle' => 'Chỉnh sửa hình ảnh'
        ]);
    }
}
