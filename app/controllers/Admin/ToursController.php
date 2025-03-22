<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\Tour;
use App\Models\Role;
use App\Models\User;
use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;

use Exception;


class ToursController extends BaseController
{
    private $tourModel;
    private $bookingModel;
    private $categoriesModel;
    private $roleModel;
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->tourModel = new Tour();
        $this->bookingModel = new Booking();
        $this->categoriesModel = new Categories();
        $this->roleModel = new Role();
    }


    ////////////////////////////////////////////
    ///////////////  BOOKINGS  ///////////////

    public function bookings()
    {
        if (!$this->checkPermission(PERM_VIEW_BOOKINGS)) {
            $this->setFlashMessage('error', 'Bạn không có quyền truy cập trang này');
            $this->view('error/403');
            return;
        }

        // Khởi tạo biến $filters từ các tham số GET
        $filters = [
            'search' => $_GET['search'] ?? '',
            'status' => $_GET['status'] ?? '',
            'tour_category' => $_GET['tour_category'] ?? '',
            'payment_status' => $_GET['payment_status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
        ];

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;


        $bookings = $this->bookingModel->getPaginated($page, $limit, $filters);

        $tourCategories = $this->categoriesModel->getAll();
        // Phân loại danh mục thành cha-con
        $parentCategories = [];
        $childCategories = [];

        foreach ($tourCategories as $category) {
            if (empty($category['parent_id'])) {
                $parentCategories[] = $category;
            } else {
                if (!isset($childCategories[$category['parent_id']])) {
                    $childCategories[$category['parent_id']] = [];
                }
                $childCategories[$category['parent_id']][] = $category;
            }
        }

        $this->view('admin/booking/index', [
            'bookings' => $bookings,
            'tourCategories' => $tourCategories,
            'parentCategories' => $parentCategories,
            'childCategories' => $childCategories,
            'filters' => $filters
        ]);
    }

    public function bookingDetails($id)
    {
        $booking = $this->bookingModel->getBookingDetails($id);

        // var_dump($booking);
        $this->view('admin/booking/details', [
            'booking' => $booking['booking'],
            'tour' => $booking['tour'],
            'payments' => $booking['payments'],
            'latest_payment' => $booking['latest_payment'],
            'booking_history' => $booking['booking_history'],
            'invoice' => $booking['invoice']
        ]);
    }


    ////////////////////////////////////////////
    ///////////////  TOURS  ///////////////

    public function index()
    {
        if (!$this->checkPermission(PERM_VIEW_TOURS)) {
            $this->setFlashMessage('error', 'Bạn không có quyền truy cập trang này');
            $this->view('error/403');
            return; // Không tiếp tục thực hiện các bước sau nếu quyền truy cập không đúng. �� đây, nếu truy cập không h��p lệ, ta s�� chuyển hướng về trang quản trị. �� trang thông tin chi tiết, đây chỉ là một ví dụ, bạn có thể thêm các check và xử lý khác theo cách tùy chỉnh.
        }

        $tours = $this->tourModel->getAll();
        $this->view('admin/tours/index', ['tours' => $tours]);
    }

    public function createTour()
    {
        $categories = $this->categoriesModel->getTitle('id', 'name', 'tour_categories');
        $locations = $this->categoriesModel->getTitle('id', 'name', 'locations');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Thông tin cơ bản
            $currentUser = $this->getCurrentUser();
            $currentUserId = isset($currentUser['id']) ? $currentUser['id'] : null;

            $title = $_POST['title'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $price = $_POST['price'] ?? 0;
            $sale_price = $_POST['sale_price'] ?? null;
            $duration = $_POST['duration'] ?? '';
            $group_size = $_POST['group_size'] ?? '';

            $category_id = $_POST['category_id'] ?? null;
            $location_id = $_POST['location_id'] ?? null;
            $departure_location_id = $_POST['departure_location_id'] ?? null;

            $description = $_POST['description'] ?? '';
            $content = $_POST['content'] ?? '';

            // Chi tiết tour
            $included = $_POST['included'] ?? '';
            $excluded = $_POST['excluded'] ?? '';

            // Lịch trình
            $itinerary = $_POST['itinerary'] ?? [];
            // mảng lịch trình
            $processedItinerary = [];
            if (!empty($itinerary)) {
                foreach ($itinerary as $dayIndex => $dayData) {
                    $processedItinerary[$dayIndex] = [
                        'title' => $dayData['title'] ?? '',
                        'description' => $dayData['description'] ?? '',
                        'meals' => $dayData['meals'] ?? [],
                        'accommodation' => $dayData['accommodation'] ?? ''
                    ];
                }
            }

            // SEO & Cài đặt
            $meta_title = $_POST['meta_title'] ?? '';
            $meta_description = $_POST['meta_description'] ?? '';
            $status = $_POST['status'] ?? 'active';
            $featured = isset($_POST['featured']) ? 1 : 0;

            $tourData = [
                'title' => $title,
                'slug' => $slug ?: createSlug($title),
                'description' => $description,
                'content' => $content,
                'duration' => $duration,
                'group_size' => $group_size,
                'price' => $price,
                'sale_price' => $sale_price,
                'category_id' => $category_id,
                'location_id' => $location_id,
                'departure_location_id' => $departure_location_id,
                'included' => $included,
                'excluded' => $excluded,
                'itinerary' => json_encode($processedItinerary, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'status' => $status,
                'featured' => $featured,
                'views' => 0,
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            $this->tourModel->insertTour($tourData);
            $this->setFlashMessage('success', 'Thêm tour thành công');
            header('location:' . UrlHelper::route('admin/tours'));

            exit;
        }

        $this->view('admin/tours/createTour', ['categories' => $categories, 'locations' => $locations]);
    }

    public function editTour($id)
    {
        $currentTour = $this->tourModel->getTourDetails($id);
        $categories = $this->categoriesModel->getTitle('id', 'name', 'tour_categories');
        $locations = $this->categoriesModel->getTitle('id', 'name', 'locations');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Thông tin cơ bản
            $currentUser = $this->getCurrentUser();
            $currentUserId = isset($currentUser['id']) ? $currentUser['id'] : null;
            $id = $_POST["id"] ?? null;
            $title = $_POST['title'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $price = $_POST['price'] ?? 0;
            $sale_price = $_POST['sale_price'] ?? null;
            $duration = $_POST['duration'] ?? '';
            $group_size = $_POST['group_size'] ?? '';

            $category_id = $_POST['category_id'] ?? null;
            $location_id = $_POST['location_id'] ?? null;
            $departure_location_id = $_POST['departure_location_id'] ?? null;

            $description = $_POST['description'] ?? '';
            $content = $_POST['content'] ?? '';

            // Chi tiết tour
            $included = $_POST['included'] ?? '';
            $excluded = $_POST['excluded'] ?? '';

            // Lịch trình
            $itinerary = $_POST['itinerary'] ?? [];
            // mảng lịch trình
            $processedItinerary = [];
            if (!empty($itinerary)) {
                foreach ($itinerary as $dayIndex => $dayData) {
                    $processedItinerary[$dayIndex] = [
                        'title' => $dayData['title'] ?? '',
                        'description' => $dayData['description'] ?? '',
                        'meals' => $dayData['meals'] ?? [],
                        'accommodation' => $dayData['accommodation'] ?? ''
                    ];
                }
            }

            // SEO & Cài đặt
            $meta_title = $_POST['meta_title'] ?? '';
            $meta_description = $_POST['meta_description'] ?? '';
            $status = $_POST['status'] ?? 'active';
            $featured = isset($_POST['featured']) ? 1 : 0;

            $tourData = [
                'title' => $title,
                'slug' => $slug ?: createSlug($title),
                'description' => $description,
                'content' => $content,
                'duration' => $duration,
                'group_size' => $group_size,
                'price' => $price,
                'sale_price' => $sale_price,
                'category_id' => $category_id ?: null,
                'location_id' => $location_id ?: null,
                'departure_location_id' => $departure_location_id ?: null,
                'included' => $included,
                'excluded' => $excluded,
                'itinerary' => json_encode($processedItinerary, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'status' => $status,
                'featured' => $featured ?: 0,
                'updated_by' => $currentUserId,
                'id' => $id,
            ];

            $result = $this->tourModel->updateTour($tourData);
            if ($result) {
                $this->setFlashMessage('success', 'Sửa tour thành công');
            } else {
                $this->setFlashMessage('error', 'Không thể cập nhật tour. Vui lòng kiểm tra lại dữ liệu.');
            }
            header('location:' . UrlHelper::route('admin/tours'));
            exit;
        } else {
            $this->view('admin/tours/editTour', [
                'tour' => $currentTour,
                'categories' => $categories,
                'locations' => $locations
            ]);
        }
    }

    public function deleteTour($id)
    {
        $tour = $this->tourModel->getTourDetails($id);
        if (!$tour) {
            $this->setFlashMessage('error', 'Tour không tồn tại');
            header('location:' . UrlHelper::route('admin/tours'));
            exit;
        }

        $this->categoriesModel->deleteById($id, 'tours');
        $this->setFlashMessage('success', 'Xóa tour thành công');
        header('location:' . UrlHelper::route('admin/tours'));
        exit;
    }



    ////////////////////////////////////////////
    ///////////////  CATEGORIES  ///////////////

    public function categories()
    {
        $categories = $this->categoriesModel->getAll();
        $this->view('admin/tours/categories', ['categories' => $categories]);
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

            // if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            //     try {
            //         $image = CloudinaryHelper::upload($_FILES['image']['tmp_name'], 'categories');
            //         if (!isset($image['secure_url'])) {
            //             throw new Exception('Lỗi khi upload ảnh');
            //         }
            //         $imageUrl = $image['secure_url'];
            //         $formData['image'] = $imageUrl;
            //     } catch (Exception $e) {
            //         $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
            //         $this->view('admin/tours/createCategory', ['formData' => $formData]);
            //         return;
            //     }
            // }

            if (!$formData['name'] || !$formData['description'] || !$formData['status']) {
                $this->setFlashMessage('error', 'Vui lòng nhập đủ thông tin');
                $this->view('admin/tours/createCategory', ['formData' => $formData]);
                return;
            }

            if ($this->categoriesModel->isSlugExists($formData['slug'])) {
                $this->setFlashMessage('error', 'Slug đã tồn tại');
                $this->view('admin/tours/createCategory', ['formData' => $formData]);
                return;
            }

            $this->categoriesModel->createCategory(
                $formData['name'],
                $formData['slug'],
                $formData['description'],
                $imageUrl,
                $formData['status'],
                $created_at,
                $updated_at
            );

            $this->setFlashMessage('success', 'Thêm danh mục thành công');
            header('location:' . UrlHelper::route('admin/tours/categories'));
            exit;
        }

        $this->view('admin/tours/createCategory', ['formData' => $formData]);
    }


    public function updateCategory($id)
    {
        if (!$id) return;

        $category = $this->categoriesModel->getCategory($id);

        if (!$category) {
            $this->setFlashMessage('error', 'Danh mục không tồn tại');
            header('Location: ' . UrlHelper::route('admin/tours/categories'));
            exit;
        }

        $formData = $category;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData['name'] = trim($_POST['name'] ?? $category['name']);
            $formData['slug'] = trim($_POST['slug'] ?? $category['slug']);
            $formData['description'] = trim($_POST['description'] ?? $category['description']);
            $formData['status'] = $_POST['status'] ?? $category['status'];
            $image = $category['image'] ?? '';



            if (empty($formData['name']) || empty($formData['description']) || empty($formData['status'])) {
                $this->setFlashMessage('error', 'Vui lòng nhập đủ thông tin');
                return $this->view('admin/tours/createCategory', ['category' => $formData, 'isUpdate' => true]);
            }

            if ($formData['slug'] !== $category['slug'] && $this->categoriesModel->isSlugExists($formData['slug'])) {
                $this->setFlashMessage('error', 'Slug đã tồn tại');
                return $this->view('admin/tours/createCategory', ['category' => $formData, 'isUpdate' => true]);
            }

            $result = $this->categoriesModel->updateCategory(
                $id,
                $formData['name'],
                $formData['slug'],
                $formData['description'],
                $image,
                $formData['status']
            );

            if (!$result) {
                $this->setFlashMessage('error', 'Cập nhật danh mục thất bại, vui lòng thử lại.');
                return $this->view('admin/tours/createCategory', ['category' => $formData, 'isUpdate' => true]);
            }

            $this->setFlashMessage('success', 'Cập nhật danh mục thành công');
            header('Location: ' . UrlHelper::route('admin/tours/categories'));
            exit;
        }

        $this->view('admin/tours/createCategory', ['category' => $category, 'isUpdate' => true]);
    }


    public function deleteCategory($id)
    {
        $category = $this->categoriesModel->getCategory($id);
        if (!$category) {
            $this->setFlashMessage('error', 'Danh mục không tồn tại');
            header('location:' . UrlHelper::route('admin/tours/categories'));
            exit;
        }

        $this->categoriesModel->deleteById($id, 'tour_categories');
        $this->setFlashMessage('success', 'Xóa danh mục thành công');
        header('location:' . UrlHelper::route('admin/tours/categories'));
        exit;
    }
}
