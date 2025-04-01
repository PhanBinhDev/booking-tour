<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Role;
use App\Models\User;
use App\Models\NewsCategories;
use App\Models\NewsModel;
use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;
use App\Helpers\UtilsHelper;
use Exception;


class NewsController extends BaseController
{
    private $roleModel;
    private $userModel;
    private $NewsCategories;
    private $NewsModel;
    public function __construct()
    {
        $this->userModel = new User();
        $this->roleModel = new Role();
        $this->NewsCategories = new NewsCategories();
        $this->NewsModel = new NewsModel();
    }
    /////NEWS
    public function index()
    {
        // Get query parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
        $direction = isset($_GET['direction']) ? $_GET['direction'] : 'desc';

        // Get news list with pagination and filters
        $newsData = $this->NewsModel->getNewsList([
            'page' => $page,
            'per_page' => $perPage,
            'search' => $search,
            'status' => $status,
            'category_id' => $categoryId,
            'sort' => $sort,
            'direction' => $direction,
            'include_categories' => true
        ]);

        // Get all categories for the filter dropdown
        $categories = $this->NewsCategories->getAll();

        // Pass data to view
        $this->view('admin/news/index', [
            'news' => $newsData['items'],
            'pagination' => $newsData['pagination'],
            'categories' => $categories,
            'filters' => [
                'search' => $search,
                'status' => $status,
                'category' => $categoryId,
                'sort' => $sort,
                'direction' => $direction
            ]
        ]);
    }
    public function createNews()
    {
        $categories = $this->NewsCategories->getTitle('id', 'name', 'news_categories');


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentUser = $this->getCurrentUser();
            $currentUserId = isset($currentUser['id']) ? $currentUser['id'] : null;

            $title = $_POST['title'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $summary = $_POST['summary'] ?? '';
            $content = $_POST['content'] ?? '';
            $meta_title = $_POST['meta_title'] ?? '';
            $meta_description = $_POST['meta_description'] ?? '';
            $status = $_POST['status'] ?? '';
            $category_id = $_POST['category_id'] ?? '';

            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                try {

                    // Upload ảnh và lưu thông tin
                    $uploadResult = CloudinaryHelper::upload($_FILES['featured_image']['tmp_name'], 'categories');

                    if (!isset($uploadResult['secure_url'])) {
                        throw new Exception('Lỗi khi upload ảnh');
                    }

                    $imageUrl = $uploadResult['secure_url'];
                    $formData['image'] = $imageUrl;
                } catch (Exception $e) {
                    $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                    return;
                }
            }

            $data = [
                'title' => $title,
                'slug' => $slug,
                'summary' => $summary,
                'content' => $content,
                'featured_image' => $formData['image'],
                'category_id' => $category_id,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'status' => $status,
                'featured' => true,
                'views' => 0,
                'created_by' => $currentUserId,
                'published_at' => date('Y-m-d H:i:s')
            ];

            $insertId = $this->NewsModel->create($data);

            if ($insertId) {
                $this->setFlashMessage('success', 'Thêm tin tức thành công');
                $this->redirect(UrlHelper::route('admin/news/index'));
                exit;
            } else {
                $this->setFlashMessage('error', 'Thêm tin tức thất bại!');
                $this->view('admin/news/createNews', ['categories' => $categories]);
            }
        }

        $this->view('admin/news/createNews', ['categories' => $categories]);
    }

    public function createByEditor()
    {
        $categories = $this->NewsCategories->getAll();
        $this->view('admin/news/createByEditor', [
            'categories' => $categories
        ]);
    }

    public function updateNews($id)
    {
        try {
            // Get current news article
            $news = $this->NewsModel->getById($id);

            if (!$news) {
                throw new \Exception("Bài viết không tồn tại");
            }

            // Get current user
            $currentUser = $this->getCurrentUser();
            $currentUserId = isset($currentUser['id']) ? $currentUser['id'] : null;

            if (!$currentUserId) {
                throw new \Exception("Người dùng chưa đăng nhập hoặc không có quyền");
            }

            // Get categories for this news article
            $newsCategories = $this->NewsModel->getNewsCategories($id);

            // Get all categories
            $allCategories = $this->NewsCategories->getAll();

            // Process form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get basic form data
                $title = trim($_POST['title'] ?? '');
                $slug = trim($_POST['slug'] ?? '');
                $excerpt = trim($_POST['excerpt'] ?? '');
                $content = $_POST['content'] ?? '{}'; // Editor.js JSON content
                $status = $_POST['action'] === 'publish' ? 'published' : 'draft';
                $categories = $_POST['categories'] ?? [];
                $metaTitle = trim($_POST['meta_title'] ?? $title);
                $metaDescription = trim($_POST['meta_description'] ?? $excerpt);
                $featured = isset($_POST['featured']) ? 1 : 0;
                $publishedAt = $_POST['published_at'] ?? date('Y-m-d H:i:s');

                // Validate required fields
                if (empty($title)) {
                    $this->setFlashMessage('error', 'Vui lòng nhập tiêu đề bài viết');
                    $this->redirect(UrlHelper::route("admin/news/updateNews/$id"));
                    return;
                }

                // Generate slug if empty
                if (empty($slug)) {
                    $slug = \App\Helpers\UtilsHelper::createSlug($title);

                    // Check if slug exists and is not the current article's slug
                    $existingNews = $this->NewsModel->findBySlug($slug);
                    if ($existingNews && $existingNews['id'] != $id) {
                        $slug = $slug . '-' . time();
                    }
                }

                // Featured image handling
                $featuredImage = $news['featured_image']; // Keep existing image by default

                // Check if we should remove the existing image
                if (isset($_POST['existing_featured_image']) && empty($_POST['existing_featured_image'])) {
                    $featuredImage = null;
                }

                // Handle new image upload if provided
                if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                    try {
                        // Upload to Cloudinary
                        $uploadResult = CloudinaryHelper::upload(
                            $_FILES['featured_image']['tmp_name'],
                            [
                                'folder' => 'news/featured',
                                'resource_type' => 'image'
                            ]
                        );

                        if (!isset($uploadResult['secure_url'])) {
                            throw new \Exception('Lỗi khi upload ảnh đại diện');
                        }

                        $featuredImage = $uploadResult['secure_url'];
                    } catch (\Exception $e) {
                        $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                        $this->redirect(UrlHelper::route("admin/news/updateNews/$id"));
                        return;
                    }
                }

                // Prepare news data for update
                $newsData = [
                    'title' => $title,
                    'slug' => $slug,
                    'summary' => $excerpt,
                    'content' => $content,
                    'featured_image' => $featuredImage,
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDescription,
                    'status' => $status,
                    'featured' => $featured,
                    'updated_by' => $currentUserId,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Update published date only if we're publishing and it wasn't published before
                if ($status === 'published' && $news['status'] !== 'published') {
                    $newsData['published_at'] = $publishedAt;
                }

                // Use model method with transaction handling to update news and categories
                $success = $this->NewsModel->updateWithCategories($id, $newsData, $categories);
                if (!$success) {
                    throw new \Exception('Không thể cập nhật bài viết');
                }

                // Set success message
                $actionMsg = ($status === 'published') ? 'xuất bản' : 'cập nhật';
                $this->setFlashMessage('success', "Bài viết đã được {$actionMsg} thành công");

                // Redirect to news list
                $this->redirect(UrlHelper::route('admin/news/index'));
                return;
            }

            // Render the form with existing data
            $this->view('admin/news/updateNews', [
                'news' => $news,
                'categories' => $newsCategories,
                'allCategories' => $allCategories
            ]);
        } catch (\Exception $e) {
            // Set error message
            $this->setFlashMessage('error', 'Lỗi: ' . $e->getMessage());
            $this->redirect(UrlHelper::route('admin/news/index'));
        }
    }

    public function deleteNews($id)
    {
        $news = $this->NewsModel->getById($id);
        if (!$news) {
            $this->setFlashMessage('error', 'Tin tức không tồn tại');
            header('location:' . UrlHelper::route('admin/news/index'));
            exit;
        }

        $this->NewsModel->delete($id, 'news');
        $this->setFlashMessage('success', 'Xóa tin tức thành công');
        header('location:' . UrlHelper::route('admin/news/index'));
        exit;
    }


    ///////CATEGORIES
    public function categories()
    {
        $news = $this->NewsCategories->getAll();
        $this->view('admin/news/categories', ['news' => $news]);
    }

    public function createCategory()
    {
        // Biến lưu dữ liệu form để truyền lại nếu có lỗi
        $formData = [
            'name' => '',
            'slug' => '',
            'description' => '',
            'status' => 'active',
            'image' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData['name'] = $_POST['name'] ?? '';
            $formData['slug'] = $_POST['slug'] ?? '';
            $formData['description'] = $_POST['description'] ?? '';
            $formData['status'] = $_POST['status'] ?? '';
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $imageUrl = '';
            // var_dump($_FILES);
            // die;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                try {

                    // Upload ảnh và lưu thông tin
                    $uploadResult = CloudinaryHelper::upload($_FILES['image']['tmp_name'], 'categories');

                    if (!isset($uploadResult['secure_url'])) {
                        throw new Exception('Lỗi khi upload ảnh');
                    }

                    $imageUrl = $uploadResult['secure_url'];
                    $formData['image'] = $imageUrl;
                } catch (Exception $e) {
                    $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                    return;
                }
            }

            if (!$formData['name'] || !$formData['description'] || !$formData['status']) {
                $this->setFlashMessage('error', 'Vui lòng nhập đủ thông tin');
                $this->view('admin/news/createCategory', ['formData' => $formData]);
                return;
            }

            $this->NewsCategories->createCategory(
                $formData['name'],
                $formData['slug'],
                $formData['description'],
                $formData['image'],
                $formData['status'],
                $created_at,
                $updated_at
            );

            $this->setFlashMessage('success', 'Thêm danh mục thành công');
            header('location:' . UrlHelper::route('admin/news/categories'));
            exit;
        }

        $this->view('admin/news/createCategory', ['formData' => $formData]);
    }

    public function updateCategory($id)
    {
        if (!$id) {
            $this->setFlashMessage('error', 'ID danh mục không hợp lệ');
            header('Location: ' . UrlHelper::route('admin/news/categories'));
            exit;
        }

        $category = $this->NewsCategories->getById($id);

        if (!$category) {
            $this->setFlashMessage('error', 'Danh mục không tồn tại');
            header('Location: ' . UrlHelper::route('admin/news/categories'));
            exit;
        }

        // Lấy danh sách danh mục cho select parent_id
        $categories = $this->NewsCategories->getAll("*", ["status" => "active"]);

        // Loại bỏ danh mục hiện tại khỏi danh sách parent_id
        $filteredCategories = array_filter($categories, function ($cat) use ($id) {
            return $cat['id'] != $id;
        });

        $formData = $category;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentUser = $this->getCurrentUser();
            $formData['name'] = trim($_POST['name'] ?? $category['name']);
            $formData['slug'] = trim($_POST['slug'] ?? $category['slug']);
            $formData['description'] = trim($_POST['description'] ?? $category['description']);
            $formData['status'] = $_POST['status'] ?? $category['status'];
            $formData['parent_id'] = $_POST['parent_id'] ? (int)$_POST['parent_id'] : null;

            // Giữ hình ảnh hiện tại
            $imageUrl = $category['image'] ?? '';

            // Xử lý upload hình ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                try {

                    // Upload ảnh và lưu thông tin
                    $uploadResult = CloudinaryHelper::upload($_FILES['image']['tmp_name'], 'categories');

                    if (!isset($uploadResult['secure_url'])) {
                        throw new Exception('Lỗi khi upload ảnh');
                    }

                    $imageUrl = $uploadResult['secure_url'];
                    $formData['image'] = $imageUrl;
                } catch (Exception $e) {
                    $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                    $this->view('admin/news/updateCategory', [
                        'category' => $formData,
                        'categories' => $filteredCategories
                    ]);
                    return;
                }
            }

            // Kiểm tra dữ liệu
            if (empty($formData['name'])) {
                $this->setFlashMessage('error', 'Vui lòng nhập tên danh mục');
                $this->view('admin/news/updateCategory', [
                    'category' => $formData,
                    'categories' => $filteredCategories
                ]);
                return;
            }

            // Tạo slug nếu không có
            if (empty($formData['slug'])) {
                $formData['slug'] = createSlug($formData['name']);
            }


            // Cập nhật danh mục
            $result = $this->NewsCategories->updateCategory(
                $id,
                $formData['name'],
                $formData['slug'],
                $formData['description'],
                $imageUrl,
                $formData['status'],
                $formData['parent_id']
            );

            if (!$result) {
                $this->setFlashMessage('error', 'Cập nhật danh mục thất bại, vui lòng thử lại.');
                $this->view('admin/news/updateCategory', [
                    'category' => $formData,
                    'categories' => $filteredCategories
                ]);
                return;
            }

            $this->setFlashMessage('success', 'Cập nhật danh mục thành công');
            header('Location: ' . UrlHelper::route('admin/news/categories'));
            exit;
        }

        $this->view('admin/news/updateCategory', [
            'category' => $category,
            'categories' => $filteredCategories
        ]);
    }


    public function deleteCategory($id)
    {
        $category = $this->NewsCategories->getById($id);
        if (!$category) {
            $this->setFlashMessage('error', 'Danh mục không tồn tại');
            $this->redirect(UrlHelper::route('admin/news/categories'));
        }

        $this->NewsCategories->deleteById($id, 'news_categories');
        $this->setFlashMessage('success', 'Xóa danh mục thành công');
        $this->redirect(UrlHelper::route('admin/news/categories'));
    }

    public function store()
    {
        try {
            // Get current user
            $currentUser = $this->getCurrentUser();
            $currentUserId = isset($currentUser['id']) ? $currentUser['id'] : null;

            if (!$currentUserId) {
                throw new \Exception("Người dùng chưa đăng nhập hoặc không có quyền");
            }

            // Get basic form data
            $title = trim($_POST['title'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $excerpt = trim($_POST['excerpt'] ?? '');
            $content = $_POST['content'] ?? '{}'; // Editor.js JSON content
            $status = $_POST['action'] === 'publish' ? 'published' : 'draft';
            $categories = $_POST['categories'] ?? [];
            $metaTitle = trim($_POST['meta_title'] ?? $title);
            $metaDescription = trim($_POST['meta_description'] ?? $excerpt);
            $featured = isset($_POST['featured']) ? 1 : 0;
            $publishedAt = $_POST['published_at'] ?? date('Y-m-d H:i:s');

            // Validate required fields
            if (empty($title)) {
                $this->setFlashMessage('error', 'Vui lòng nhập tiêu đề bài viết');
                $this->redirect(UrlHelper::route('admin/news/createByEditor'));
                return;
            }

            // Generate slug if empty
            if (empty($slug)) {
                $slug = \App\Helpers\UtilsHelper::createSlug($title);

                // Check if slug exists
                if ($this->NewsModel->findBySlug($slug)) {
                    $slug = $slug . '-' . time();
                }
            }

            // Featured image handling
            $featuredImage = null;

            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                try {
                    // Upload to Cloudinary
                    $uploadResult = CloudinaryHelper::upload(
                        $_FILES['featured_image']['tmp_name'],
                        [
                            'folder' => 'news/featured',
                            'resource_type' => 'image'
                        ]
                    );

                    if (!isset($uploadResult['secure_url'])) {
                        throw new \Exception('Lỗi khi upload ảnh đại diện');
                    }

                    $featuredImage = $uploadResult['secure_url'];
                } catch (\Exception $e) {
                    $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                    $this->redirect(UrlHelper::route('admin/news/createByEditor'));
                    return;
                }
            }

            // Prepare news data
            $newsData = [
                'title' => $title,
                'slug' => $slug,
                'summary' => $excerpt,
                'content' => $content, // EditorJS JSON content
                'featured_image' => $featuredImage,
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'status' => $status,
                'featured' => $featured,
                'views' => 0,
                'created_by' => $currentUserId,
                'published_at' => ($status === 'published') ? $publishedAt : null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Use model method with transaction handling
            $newsId = $this->NewsModel->createWithCategories($newsData, $categories);

            if (!$newsId) {
                throw new \Exception('Không thể tạo bài viết mới');
            }

            // Set success message
            $actionMsg = ($status === 'published') ? 'xuất bản' : 'lưu nháp';
            $this->setFlashMessage('success', "Bài viết đã được {$actionMsg} thành công");

            // Redirect to news list
            $this->redirect(UrlHelper::route('admin/news/index'));
        } catch (\Exception $e) {
            // Log error
            error_log('Error creating news: ' . $e->getMessage());

            // Set error message
            $this->setFlashMessage('error', 'Lỗi: ' . $e->getMessage());
            $this->redirect(UrlHelper::route('admin/news/createNews'));
        }
    }

    public function preview($id)
    {
        // Get news article details
        $news = $this->NewsModel->getById($id);

        if (!$news) {
            $this->setFlashMessage('error', 'Bài viết không tồn tại');
            $this->redirect(UrlHelper::route('admin/news/index'));
            return;
        }

        // Get categories for this article
        $categories = $this->NewsModel->getNewsCategories($id);

        // Get author information
        $author = $this->userModel->getById($news['created_by']);
        $authorName = $author ? $author['username'] : 'Unknown';

        // Create view data
        $viewData = [
            'news' => $news,
            'categories' => $categories,
            'authorName' => $authorName
        ];

        // Load preview view
        $this->view('admin/news/preview', $viewData);
    }
}
