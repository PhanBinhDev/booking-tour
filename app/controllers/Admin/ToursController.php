<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\Tour;
use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;


use Exception;


class ToursController extends BaseController
{
    private $tourModel;
    private $imgModel;
    private $bookingModel;
    private $categoriesModel;
    private $roleModel;
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->imgModel = new Image();
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


    public function updateStatus($id)
    {
        $status = $_POST['status'] ?? null;

        $allowed = ['pending', 'confirmed', 'completed', 'cancelled'];

        if (!in_array($status, $allowed)) {
            die("Trạng thái không hợp lệ.");
        }

        $success = $this->bookingModel->updateStatus($id, $status);

        if ($success) {
            $this->setFlashMessage('success', 'Sửa trạng thái thành công');
            header("Location: " . UrlHelper::route('admin/bookings'));
            exit;
        } else {
            $this->setFlashMessage('error', 'Sửa trạng thái thất bại');
            exit;
        }
    }

    ////////////////////////////////////////////
    ///////////////  TOURS  ///////////////

    public function index()
    {
        if (!$this->checkPermission(PERM_VIEW_TOURS)) {
            $this->setFlashMessage('error', 'Bạn không có quyền truy cập trang này');
            $this->view('error/403');
            return;
        }

        // Lấy tham số từ URL
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $sort = $_GET['sort'] ?? 'created_at';
        $direction = $_GET['direction'] ?? 'desc';

        // Xây dựng bộ lọc
        $filters = [
            'search' => $_GET['search'] ?? '',
            'status' => $_GET['status'] ?? '',
            'category_id' => $_GET['category_id'] ?? '',
            'location_id' => $_GET['location_id'] ?? '',
            'featured' => isset($_GET['featured']) ? $_GET['featured'] : '',
            'price_min' => $_GET['price_min'] ?? '',
            'price_max' => $_GET['price_max'] ?? '',
            'duration' => $_GET['duration'] ?? '',
        ];

        // Lấy danh sách tour có phân trang
        $result = $this->tourModel->getPaginated($page, $limit, $filters, $sort, $direction);

        // Lấy danh sách danh mục cho bộ lọc

        $tourCategories = $this->categoriesModel->getAll();
        $locations = $this->categoriesModel->getTitle('id', 'name', 'locations');

        // Truyền dữ liệu cho view
        $this->view('admin/tours/index', [
            'tours' => $result['items'],
            'pagination' => $result['pagination'],
            'filters' => $filters,
            'sort' => $sort,
            'direction' => $direction,
            'categories' => $tourCategories,
            'locations' => $locations
        ]);
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
            $is_featured = 1;

            // Xử lý upload ảnh đại diện
            $imageData = [
                'title' => $title,
                'description' => $description,
                'alt_text' => $title,
                'category' => 'tour',
                'user_id' => $currentUserId
            ];

            try {
                $imageId = CloudinaryHelper::uploadAndSave(
                    $_FILES['featured_image']['tmp_name'],
                    $imageData,
                    'tour_image',
                    $currentUserId
                );
                if (!$imageId) {
                    throw new \Exception("Không thể upload và lưu hình ảnh");
                }
                $tourData['image_id'] = $imageId;
            } catch (\Exception $e) {
                $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                $this->view('admin/tours/createTour', [
                    'categories' => $categories,
                    'locations' => $locations,
                    'formData' => $_POST
                ]);
                return;
            }

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

            $tourId = $this->tourModel->insertTour($tourData);
            $this->tourModel->attachImage($tourId, $imageId, $is_featured);

            $tourDates = $_POST['tour_dates'] ?? [];

            foreach ($tourDates as $dateItem) {
                if (!empty($dateItem['start_date']) && !empty($dateItem['end_date'])) {
                    $this->tourModel->addTourDate($tourId, [
                        'start_date' => $dateItem['start_date'],
                        'end_date' => $dateItem['end_date'],
                        'available_seats' => $dateItem['available_seats'] ?? null,
                    ]);
                }
            }

            // Xử lý upload nhiều ảnh chi tiết
            if (isset($_FILES['detail_image']) && !empty($_FILES['detail_image']['name'][0])) {
                $detailImagesCount = count($_FILES['detail_image']['name']);
                $detailImageIds = [];

                for ($i = 0; $i < $detailImagesCount; $i++) {
                    // Kiểm tra nếu file hợp lệ
                    if ($_FILES['detail_image']['error'][$i] === UPLOAD_ERR_OK) {
                        $tempFile = $_FILES['detail_image']['tmp_name'][$i];
                        $detailImageData = [
                            'title' => $title . ' - Chi tiết ' . ($i + 1),
                            'description' => 'Hình ảnh chi tiết cho tour: ' . $title,
                            'alt_text' => $title . ' chi tiết',
                            'category' => 'tour_detail',
                            'user_id' => $currentUserId
                        ];

                        try {
                            $detailImageId = CloudinaryHelper::uploadAndSave(
                                $tempFile,
                                $detailImageData,
                                'tour_detail_image',
                                $currentUserId
                            );

                            if ($detailImageId) {
                                $detailImageIds[] = $detailImageId;
                                $this->tourModel->attachImage($tourId, $detailImageId, 0);
                            }
                        } catch (\Exception $e) {
                            error_log('Lỗi khi upload ảnh chi tiết ' . ($i + 1) . ': ' . $e->getMessage());
                            continue;
                        }
                    }
                }
            }

            $this->setFlashMessage('success', 'Thêm tour thành công');
            header('location:' . UrlHelper::route('admin/tours'));
            exit;
        }

        $this->view('admin/tours/createTour', ['categories' => $categories, 'locations' => $locations]);
    }

    public function publishTour($id)
    {
        // Verify tour exists
        $tour = $this->tourModel->getTourDetails($id);
        if (!$tour) {
            $this->setFlashMessage('error', 'Tour không tồn tại');
            $this->redirect(UrlHelper::route('admin/tours'));
            return;
        }

        // Check if method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token if your application uses it
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
                $this->setFlashMessage('error', 'Phiên làm việc hết hạn, vui lòng thử lại');
                $this->redirect(UrlHelper::route('admin/tours'));
                return;
            }

            // Get current user for tracking who published
            $currentUser = $this->getCurrentUser();
            $currentUserId = isset($currentUser['id']) ? $currentUser['id'] : null;

            // Update tour status
            $updateData = [
                'id' => $id,
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s'),
                'updated_by' => $currentUserId
            ];

            $result = $this->tourModel->updateTour($updateData);

            if ($result) {
                $this->setFlashMessage('success', 'Tour đã được xuất bản thành công');
            } else {
                $this->setFlashMessage('error', 'Không thể xuất bản tour. Vui lòng thử lại');
            }

            $this->redirect(UrlHelper::route('admin/tours'));
            return;
        }

        // If not POST, redirect back (this endpoint should only be accessed via POST)
        $this->redirect(UrlHelper::route('admin/tours'));
    }

    public function editTour($id)
    {
        $currentTour = $this->tourModel->getTourDetails($id);
        $categories = $this->categoriesModel->getTitle('id', 'name', 'tour_categories');
        $locations = $this->categoriesModel->getTitle('id', 'name', 'locations');
        $feature_img = $this->tourModel->getFeaturedImageByTourId($id);
        $details_img = $this->tourModel->getAllImagesExcludingFeatured($id);

        // Lấy lịch khởi hành hiện tại
        $tour_dates = $this->tourModel->getTourDates($id);
        $currentTour['dates'] = $tour_dates;

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

            // Cập nhật tour trước để đảm bảo ID tour hợp lệ
            $result = $this->tourModel->updateTour($tourData);
            if (!$result) {
                $this->setFlashMessage('error', 'Không thể cập nhật tour. Vui lòng kiểm tra lại dữ liệu.');
                header('location:' . UrlHelper::route('admin/tours'));
                exit;
            }

            // Xử lý lịch khởi hành (tour_dates)
            if (isset($_POST['tour_dates']) && is_array($_POST['tour_dates'])) {
                // Lấy danh sách date ID hiện tại để xóa những ngày không còn tồn tại
                $existingDateIds = array_column($tour_dates, 'id');
                $updatedDateIds = [];

                foreach ($_POST['tour_dates'] as $dateIndex => $dateData) {
                    $dateId = isset($dateData['id']) ? $dateData['id'] : null;
                    $startDate = $dateData['start_date'] ?? null;
                    $endDate = $dateData['end_date'] ?? null;
                    $availableSeats = $dateData['available_seats'] ?? null;

                    // Validate date inputs
                    if (empty($startDate) || empty($endDate)) {
                        continue;
                    }

                    $tourDateData = [
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'available_seats' => $availableSeats
                    ];

                    if ($dateId && in_array($dateId, $existingDateIds)) {
                        // Update existing date
                        $this->tourModel->updateTourDate($dateId, $tourDateData);
                        $updatedDateIds[] = $dateId;
                    } else {
                        // Insert new date using the existing addTourDate method
                        $this->tourModel->addTourDate($id, $tourDateData);
                    }
                }

                // Delete dates that were removed
                $datesToDelete = array_diff($existingDateIds, $updatedDateIds);
                foreach ($datesToDelete as $dateId) {
                    $this->tourModel->deleteTourDate($dateId);
                }
            }

            // Xử lý xóa ảnh đại diện nếu có yêu cầu
            if (isset($_POST['remove_featured_image']) && !empty($_POST['remove_featured_image'])) {
                // Xóa ảnh đại diện cũ
                $this->tourModel->resetFeaturedImages($id);
                error_log('Đã xóa ảnh đại diện cũ của tour ID=' . $id);
            }

            // Xử lý xóa ảnh chi tiết nếu có yêu cầu
            if (isset($_POST['remove_detail_images']) && is_array($_POST['remove_detail_images'])) {
                foreach ($_POST['remove_detail_images'] as $imageIdentifier) {
                    // Cần xác định image_id từ cloudinary_id hoặc url
                    $imageId = $this->tourModel->getImageIdByIdentifier($imageIdentifier);
                    if ($imageId) {
                        $this->tourModel->removeImage($id, $imageId);
                        error_log('Đã xóa ảnh chi tiết ID=' . $imageId . ' khỏi tour ID=' . $id);
                    }
                }
            }

            // Xử lý ảnh đại diện mới
            if (
                isset($_FILES['featured_image']) &&
                $_FILES['featured_image']['error'] === UPLOAD_ERR_OK &&
                !empty($_FILES['featured_image']['tmp_name'])
            ) {
                $imageData = [
                    'title' => $title,
                    'description' => $description,
                    'alt_text' => $title,
                    'category' => 'tour',
                    'user_id' => $currentUserId
                ];

                try {
                    // Xóa ảnh đại diện cũ nếu có
                    $this->tourModel->resetFeaturedImages($id);

                    // Tải lên và lưu ảnh mới
                    $imageId = CloudinaryHelper::uploadAndSave(
                        $_FILES['featured_image']['tmp_name'],
                        $imageData,
                        'tour_image',
                        $currentUserId
                    );

                    if ($imageId) {
                        // Cập nhật ảnh đại diện mới
                        $this->tourModel->updateImage($id, $imageId, 1);
                        error_log('Cập nhật ảnh đại diện thành công: ID=' . $imageId);
                    }
                } catch (\Exception $e) {
                    error_log('Lỗi khi upload ảnh đại diện: ' . $e->getMessage());
                    $this->setFlashMessage('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                }
            }

            // Xử lý ảnh chi tiết mới
            if (
                isset($_FILES['detail_image']) &&
                is_array($_FILES['detail_image']['name']) &&
                !empty($_FILES['detail_image']['name'][0])
            ) {
                $detailImagesCount = count($_FILES['detail_image']['name']);

                for ($i = 0; $i < $detailImagesCount; $i++) {
                    if (
                        $_FILES['detail_image']['error'][$i] === UPLOAD_ERR_OK &&
                        !empty($_FILES['detail_image']['tmp_name'][$i])
                    ) {
                        $tempFile = $_FILES['detail_image']['tmp_name'][$i];
                        $detailImageData = [
                            'title' => $title . ' - Chi tiết ' . ($i + 1),
                            'description' => 'Hình ảnh chi tiết cho tour: ' . $title,
                            'alt_text' => $title . ' chi tiết',
                            'category' => 'tour_detail',
                            'user_id' => $currentUserId
                        ];

                        try {
                            $detailImageId = CloudinaryHelper::uploadAndSave(
                                $tempFile,
                                $detailImageData,
                                'tour_detail_image',
                                $currentUserId
                            );

                            if ($detailImageId) {
                                // Cập nhật ảnh chi tiết (không phải ảnh đại diện)
                                $this->tourModel->updateImage($id, $detailImageId, 0);
                                error_log('Cập nhật ảnh chi tiết thành công: ID=' . $detailImageId);
                            }
                        } catch (\Exception $e) {
                            error_log('Lỗi khi upload ảnh chi tiết ' . ($i + 1) . ': ' . $e->getMessage());
                            continue;
                        }
                    }
                }
            }

            $this->setFlashMessage('success', 'Sửa tour thành công');
            header('location:' . UrlHelper::route('admin/tours'));
            exit;
        } else {
            $this->view('admin/tours/editTour', [
                'tour' => $currentTour,
                'categories' => $categories,
                'locations' => $locations,
                'feature_img' => $feature_img,
                'details_img' => $details_img
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
        if (!$this->checkPermission(PERM_VIEW_TOURS)) {
            $this->setFlashMessage('error', 'Bạn không có quyền truy cập trang này');
            $this->view('error/403');
            return;
        }

        // Lấy tham số từ URL
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $sort = $_GET['sort'] ?? 'created_at';
        $direction = $_GET['direction'] ?? 'desc';

        // Xây dựng bộ lọc
        $filters = [
            'search' => $_GET['search'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        // Lấy danh sách danh mục có phân trang
        $options = [
            'table_alias' => 'tc',
            'columns' => 'tc.*, 
                    (SELECT COUNT(*) FROM tours t WHERE t.category_id = tc.id) as tour_count',
            'filters' => [
                'tc.status' => $filters['status'] ?: null
            ],
            'sort' => "tc.{$sort}",
            'direction' => $direction,
            'page' => $page,
            'limit' => $limit
        ];

        // Nếu có tìm kiếm
        if (!empty($filters['search'])) {
            $options['search_term'] = '%' . $filters['search'] . '%';
            $options['search_fields'] = ['tc.name', 'tc.description'];
        }

        $result = $this->categoriesModel->getPaginatedCustom($options);

        // Truyền dữ liệu cho view
        $this->view('admin/tours/categories', [
            'categories' => $result['items'],
            'pagination' => $result['pagination'],
            'filters' => $filters,
            'sort' => $sort,
            'direction' => $direction
        ]);
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
                $formData['image'],
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
        if (!$id) {
            $this->setFlashMessage('error', 'ID danh mục không hợp lệ');
            header('Location: ' . UrlHelper::route('admin/tours/categories'));
            exit;
        }

        $category = $this->categoriesModel->getCategory($id);

        if (!$category) {
            $this->setFlashMessage('error', 'Danh mục không tồn tại');
            header('Location: ' . UrlHelper::route('admin/tours/categories'));
            exit;
        }

        // Lấy danh sách danh mục cho select parent_id
        $categories = $this->categoriesModel->getAll("*", ["status" => "active"]);

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
                    $this->view('admin/tours/editCategory', [
                        'category' => $formData,
                        'categories' => $filteredCategories
                    ]);
                    return;
                }
            }

            // Kiểm tra dữ liệu
            if (empty($formData['name'])) {
                $this->setFlashMessage('error', 'Vui lòng nhập tên danh mục');
                $this->view('admin/tours/editCategory', [
                    'category' => $formData,
                    'categories' => $filteredCategories
                ]);
                return;
            }

            // Tạo slug nếu không có
            if (empty($formData['slug'])) {
                $formData['slug'] = createSlug($formData['name']);
            }

            // Kiểm tra slug trùng (chỉ khi slug thay đổi)
            if ($formData['slug'] !== $category['slug'] && $this->categoriesModel->isSlugExists($formData['slug'])) {
                $this->setFlashMessage('error', 'Slug đã tồn tại, vui lòng chọn tên khác');
                $this->view('admin/tours/editCategory', [
                    'category' => $formData,
                    'categories' => $filteredCategories
                ]);
                return;
            }

            // Cập nhật danh mục
            $result = $this->categoriesModel->updateCategory(
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
                $this->view('admin/tours/editCategory', [
                    'category' => $formData,
                    'categories' => $filteredCategories
                ]);
                return;
            }

            $this->setFlashMessage('success', 'Cập nhật danh mục thành công');
            header('Location: ' . UrlHelper::route('admin/tours/categories'));
            exit;
        }

        $this->view('admin/tours/editCategory', [
            'category' => $category,
            'categories' => $filteredCategories
        ]);
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
