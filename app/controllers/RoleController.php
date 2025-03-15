<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends BaseController {
  private $roleModel;
  private $permissionModel;
  public function __construct() {
        parent::__construct();
        $this->roleModel = new Role();
        $this->permissionModel = new Permission();
        
        // Kiểm tra quyền truy cập
        if (!$this->checkPermission(PERM_MANAGE_ROLES)) {
            // $this->setFlashMessage('error', 'Bạn không có quyền truy cập trang này');
            $this->redirectByRole();
        }
    }
  }
?>