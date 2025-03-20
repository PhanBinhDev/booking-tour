<?php

namespace App\Controllers\Admin;

use App\Config\Enum;
use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\Location;
use App\Models\Role;
use App\Models\Permission;

class LocationController extends BaseController
{
  private $locationModel;
  public function __construct()
  {
    $this->locationModel = new Location();

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
      'search' => $_GET['search'] ?? ''
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
    $this->view('admin/locations/create');
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
}