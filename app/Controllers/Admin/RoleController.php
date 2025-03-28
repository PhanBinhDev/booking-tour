<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Role;
use App\Models\Permission;
use App\Helpers\UrlHelper;

class RoleController extends BaseController {
  private $roleModel;
  private $permissionModel;
  public function __construct() {
    $this->roleModel = new Role();
    $this->permissionModel = new Permission();
    
    // Kiểm tra quyền truy cập
    if (!$this->checkPermission(PERM_MANAGE_ROLES)) {
        $this->setFlashMessage('error', 'Bạn không có quyền truy cập trang này');
        $this->redirectByRole();
    }
  }

  public function index() {
    $roles = $this->roleModel->getAllWithPermissionCount();
    $this->view('admin/roles/index', ['roles' => $roles]);
  }

    public function edit($id) {
        $this->view('admin/roles/edit', [
            'role' => $this->roleModel->getById($id)
        ]);
    }


  /**
     * Hiển thị trang phân quyền cho role
     * 
     * @param int $id ID của role
     */
  public function permissions($id) {
      $currentUser = $this->getCurrentUser();
      
      // Lấy thông tin role
      $role = $this->roleModel->getById($id);
      
      if (!$role) {
          $this->redirect(UrlHelper::route('/admin/roles'), 'Vai trò không tồn tại', 'error');
      }
      
      // Lấy danh sách tất cả các quyền, phân nhóm theo category
      $allPermissions = $this->permissionModel->getAllGroupedByCategory();
      
      // Lấy danh sách quyền hiện tại của role
      $rolePermissions = $this->roleModel->getRolePermissions($id);
      
      // Chuyển đổi danh sách quyền thành mảng ID để dễ kiểm tra
      $rolePermissionIds = array_column($rolePermissions, 'id');
      
      $this->view('admin/roles/role-permissions', [
          'user' => $currentUser,
          'role' => $role,
          'allPermissions' => $allPermissions,
          'rolePermissionIds' => $rolePermissionIds
      ]);
  }

  /**
   * Cập nhật quyền cho role
   * 
   * @param int $id ID của role
   */
  public function updatePermissions($id) {
      // Kiểm tra CSRF token
      $this->validateCSRFToken();
      
      // Lấy thông tin role
      $role = $this->roleModel->getById($id);
      
      if (!$role) {
          $this->redirect(UrlHelper::route('/admin/roles'), 'Vai trò không tồn tại', 'error');
      }
      
      // Lấy danh sách quyền được gửi từ form
      $permissionIds = isset($_POST['permissions']) ? $_POST['permissions'] : [];
      
      // Cập nhật quyền cho role
      $success = $this->roleModel->updateRolePermissions($id, $permissionIds);
      
      if ($success) {
          // Xóa cache quyền nếu có
          $this->clearPermissionCache();
          
          $this->redirect(UrlHelper::route("/admin/roles/{$id}/permissions"), 'Cập nhật quyền thành công', 'success');
      } else {
          $this->redirect(UrlHelper::route("/admin/roles/{$id}/permissions"), 'Có lỗi xảy ra khi cập nhật quyền', 'error');
      }
  }
  
  /**
   * Xóa cache quyền
   */
  private function clearPermissionCache() {
      // Xóa tất cả các cache liên quan đến quyền trong session
      foreach ($_SESSION as $key => $value) {
          if (strpos($key, 'user_') === 0 && strpos($key, '_permission_') !== false) {
              unset($_SESSION[$key]);
          }
      }
  }
}
?>