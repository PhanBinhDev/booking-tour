<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Role;
use App\Models\User;
use App\Models\NewsCategories;
use App\Models\NewsModel;
use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;

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
        $news = $this->NewsModel->getAll();
        // var_dump($news);
        $this->view('admin/news/index', ['news' => $news]);
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
                header('location:' . UrlHelper::route('admin/news/index'));
                exit;
            } else {
                $this->setFlashMessage('error', 'Thêm tin tức thất bại!');
                $this->view('admin/news/createNews', ['categories' => $categories]);
            }
        }

        $this->view('admin/news/createNews', ['categories' => $categories]);
    }

    public function updateNews($id)
    {
        $news = $this->NewsModel->getById($id);
        $id = $news['id'];
        $category = $this->NewsCategories->getById($id);
        $categories = $this->NewsCategories->getAll();

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

            $imageUrl = $news['featured_image'] ?? '';

            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                try {

                    // Upload ảnh và lưu thông tin
                    $uploadResult = CloudinaryHelper::upload($_FILES['featured_image']['tmp_name'], 'categories');

                    if (!isset($uploadResult['secure_url'])) {
                        throw new Exception('Lỗi khi upload ảnh');
                    }

                    $imageUrl = $uploadResult['secure_url'];
                } catch (Exception $e) {
                    $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                    $this->view('admin/news/updateNews', [
                        'news' => $news,
                        'category' => $category,
                        'categories' => $categories
                    ]);
                    return;
                }
            }

            $data = [
                'title' => $title,
                'slug' => $slug,
                'summary' => $summary,
                'content' => $content,
                'featured_image' => $imageUrl,
                'category_id' => $category_id,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'status' => $status,
                'featured' => true,
                'views' => 0,
                'created_by' => $currentUserId,
                'published_at' => date('Y-m-d H:i:s')
            ];

            $insertId = $this->NewsModel->update($id, $data);

            if ($insertId) {
                $this->setFlashMessage('success', 'Sửa tin tức thành công');
                header('location:' . UrlHelper::route('admin/news/index'));
                exit;
            } else {
                $this->setFlashMessage('error', 'Sửa tin tức thất bại!');
                $this->view('admin/news/updateNews', [
                    'news' => $news,
                    'category' => $category,
                    'categories' => $categories
                ]);
            }
        }


        $this->view('admin/news/updateNews', [
            'news' => $news,
            'category' => $category,
            'categories' => $categories
        ]);
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
            header('location:' . UrlHelper::route('admin/news/categories'));
            exit;
        }

        $this->NewsCategories->deleteById($id, 'news_categories');
        $this->setFlashMessage('success', 'Xóa danh mục thành công');
        header('location:' . UrlHelper::route('admin/news/categories'));
        exit;
    }
}
