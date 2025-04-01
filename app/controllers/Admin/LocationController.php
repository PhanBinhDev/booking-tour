<?php

namespace App\Controllers\Admin;

use App\Config\Enum;
use App\Controllers\BaseController;
use App\Helpers\CloudinaryHelper;
use App\Helpers\UrlHelper;
use App\Models\Image;
use App\Models\Location;

class LocationController extends BaseController
{
  private $locationModel;
  private $imageModel;
  public function __construct()
  {
    $this->locationModel = new Location();
    $this->imageModel = new Image();

    // // Kiểm tra quyền truy cập
    // if (!$this->checkPermission(PERM_MANAGE_ROLES)) {
    //   $this->setFlashMessage('error', 'Bạn không có quyền truy cập trang này');
    //   $this->redirectByRole();
    // }
  }

  public function index()
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

    // Tạo mảng filters từ các tham số GET
    $filters = [
      'region' => $_GET['region'] ?? '',
      'country' => $_GET['country'] ?? '',
      'search' => $_GET['search'] ?? '',
      'isDeleted' => '0',
    ];

    // Lấy danh sách locations đã phân trang và lọc
    $paginatedData = $this->locationModel->getPaginated($page, $limit, $filters);

    // Lấy danh sách các vùng/khu vực và quốc gia để hiển thị trong bộ lọc
    $regions = $this->locationModel->getDistinctRegions();
    $countries = !empty($filters['region'])
      ? $this->locationModel->getCountriesByRegion($filters['region'])
      : [];
    // Truyền dữ liệu đến view
    $this->view('admin/locations/index', [
      'locations' => $paginatedData['items'],
      'pagination' => $paginatedData['pagination'],
      'filters' => $filters,
      'regions' => $regions,
      'countries' => $countries
    ]);
  }

  /**
   * Hiển thị form tạo mới location
   */
  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Get form data
      $name = trim($_POST['name'] ?? '');
      $slug = trim($_POST['slug'] ?? '');
      $description = trim($_POST['description'] ?? '');
      $country = trim($_POST['country'] ?? '');
      $region = trim($_POST['region'] ?? '');
      $latitude = !empty($_POST['latitude']) ? (float)$_POST['latitude'] : null;
      $longitude = !empty($_POST['longitude']) ? (float)$_POST['longitude'] : null;
      $status = $_POST['status'] ?? 'active';

      // Basic validation
      $errors = [];
      if (empty($name)) {
        $errors['name'] = 'Tên địa điểm không được để trống';
      }

      if (empty($slug)) {
        // Generate slug from name if not provided
        $slug = $this->slugify($name);
      } else {
        // Check if slug already exists
        if ($this->locationModel->findBySlug($slug)) {
          $errors['slug'] = 'Slug đã tồn tại, vui lòng chọn slug khác';
        }
      }

      // If there are validation errors, redirect back with errors
      if (!empty($errors)) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['form_errors'] = $errors;
        $this->redirect(UrlHelper::route('admin/locations/create'));
        return;
      }

      // Handle image upload if present
      $imageUrl = null;
      if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $imageFile = $_FILES['thumbnail'];

        // Use the CloudinaryHelper to upload the image
        $resultUpload = CloudinaryHelper::upload(
          $imageFile['tmp_name'],
          'locations',
        );

        if (isset($resultUpload['secure_url'])) {
          $imageUrl = $resultUpload['secure_url'];
        } else {
          $this->setFlashMessage('error', 'Lỗi khi tải ảnh thumnail: ' . $resultUpload['error']['message']);
          $this->redirect(UrlHelper::route('admin/locations/create'));
          return;
        }
      }

      // Prepare data for insertion
      $data = [
        'name' => $name,
        'slug' => $slug,
        'description' => $description,
        'image' => $imageUrl,
        'country' => $country,
        'region' => $region,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'status' => $status
      ];

      // Create new location
      $locationId = $this->locationModel->create($data);

      if ($locationId) {
        $this->setFlashMessage('success', 'Thêm địa điểm mới thành công');
        $this->redirect(UrlHelper::route('admin/locations/show/' . $locationId));
      } else {
        $this->setFlashMessage('error', 'Có lỗi xảy ra khi thêm địa điểm mới');
        $_SESSION['form_data'] = $_POST;
        $this->redirect(UrlHelper::route('admin/locations/create'));
      }
    } else {
      $this->view('admin/locations/create');
    }
  }

  public function show($id)
  {
    $location = $this->locationModel->getById($id);
    if (!$location) {
      $this->setFlashMessage('error', 'Địa điểm không tồn tại');
      $this->redirect(UrlHelper::route('admin/locations'));
    }

    $this->view('admin/locations/show', ['location' => $location]);
  }

  public function edit($id)
  {
    $location = $this->locationModel->getById($id);
    if (!$location) {
      $this->setFlashMessage('error', 'Địa điểm không tồn tại');
      $this->redirect(UrlHelper::route('admin/locations'));
    }

    $this->view('admin/locations/edit', ['location' => $location]);
  }

  public function delete($id)
  {
    $location = $this->locationModel->getById($id);
    if (!$location) {
      $this->setFlashMessage('error', 'Địa điểm không tồn tại');
      $this->redirect(UrlHelper::route('admin/locations'));
    }

    $this->locationModel->deleteSoft($id);
    $this->setFlashMessage('success', 'Xóa địa điểm thành công');
    $this->redirect(UrlHelper::route('admin/locations'));
  }

  public function changeStatus($id)
  {
    $location = $this->locationModel->getById($id);
    if (!$location) {
      $this->setFlashMessage('error', 'Địa điểm không tồn tại');
      $this->redirect(UrlHelper::route('admin/locations'));
    }

    // Cập nhật trạng thái
    $newStatus = $location['status'] == Enum::LOCATION_STATUS['ACTIVE']
      ? Enum::LOCATION_STATUS['INACTIVE']
      : Enum::LOCATION_STATUS['ACTIVE'];
    $this->locationModel->update($id, ['status' => $newStatus]);

    $this->setFlashMessage('success', 'Cập nhật trạng thái thành công');
    $this->redirect(UrlHelper::route('admin/locations/show/' . $id));
  }

  private function slugify($text)
  {
    // Remove accents
    $text = $this->removeAccents($text);

    // Convert to lowercase
    $text = strtolower($text);

    // Remove special characters
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);

    // Remove duplicate dashes
    $text = preg_replace('/-+/', '-', $text);

    // Trim dashes from beginning and end
    $text = trim($text, '-');

    return $text;
  }

  /**
   * Remove accents from string
   */
  private function removeAccents($string)
  {
    if (!preg_match('/[\x80-\xff]/', $string)) {
      return $string;
    }

    $chars = [
      // Latin-1 Supplement
      'à' => 'a',
      'á' => 'a',
      'â' => 'a',
      'ã' => 'a',
      'ä' => 'a',
      'å' => 'a',
      'æ' => 'ae',
      'ç' => 'c',
      'è' => 'e',
      'é' => 'e',
      'ê' => 'e',
      'ë' => 'e',
      'ì' => 'i',
      'í' => 'i',
      'î' => 'i',
      'ï' => 'i',
      'ð' => 'd',
      'ñ' => 'n',
      'ò' => 'o',
      'ó' => 'o',
      'ô' => 'o',
      'õ' => 'o',
      'ö' => 'o',
      'ø' => 'o',
      'ù' => 'u',
      'ú' => 'u',
      'û' => 'u',
      'ü' => 'u',
      'ý' => 'y',
      'ÿ' => 'y',
      'À' => 'A',
      'Á' => 'A',
      'Â' => 'A',
      'Ã' => 'A',
      'Ä' => 'A',
      'Å' => 'A',
      'Æ' => 'AE',
      'Ç' => 'C',
      'È' => 'E',
      'É' => 'E',
      'Ê' => 'E',
      'Ë' => 'E',
      'Ì' => 'I',
      'Í' => 'I',
      'Î' => 'I',
      'Ï' => 'I',
      'Ð' => 'D',
      'Ñ' => 'N',
      'Ò' => 'O',
      'Ó' => 'O',
      'Ô' => 'O',
      'Õ' => 'O',
      'Ö' => 'O',
      'Ø' => 'O',
      'Ù' => 'U',
      'Ú' => 'U',
      'Û' => 'U',
      'Ü' => 'U',
      'Ý' => 'Y',
      // Vietnamese specific
      'ă' => 'a',
      'Ă' => 'A',
      'â' => 'a',
      'Â' => 'A',
      'đ' => 'd',
      'Đ' => 'D',
      'ê' => 'e',
      'Ê' => 'E',
      'ô' => 'o',
      'Ô' => 'O',
      'ơ' => 'o',
      'Ơ' => 'O',
      'ư' => 'u',
      'Ư' => 'U'
    ];

    return strtr($string, $chars);
  }
}
