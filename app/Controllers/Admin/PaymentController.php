<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\UrlHelper;
use App\Models\PaymentMethod;

class PaymentController extends BaseController {
  protected $paymentMethodModel;
  private $activityLogModel;
  public function __construct() {
    // $this->paymentMethodModel = new PaymentMethod();
      // // Áp dụng middleware để kiểm tra quyền admin
      $route = $this->getRouteByRole();
      $roleBase = 'admin';
      $role = $this->getRole();
      if ($role !== $roleBase) {
          $this->redirect($route);
      }

      $this->paymentMethodModel = new PaymentMethod();
  }

  public function methods() {
    $methods = $this->paymentMethodModel->getAll();
    $this->view('admin/payment/methods/index', [
        'methods' => $methods
    ]);
  }

  public function createMethod() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and save new payment method
            $data = $this->validateMethodData($_POST);
            if (!isset($data['errors'])) {
                $this->paymentMethodModel->create($data);
                $this->setFlashMessage('success', 'Phương thức thanh toán đã được tạo thành công');
                $this->redirect(UrlHelper::route('/admin/payment/methods'));
            } else {
              // Display errors if any
              $this->setFlashMessage('error', 'Vui lòng kiểm tra lại thông tin');
              return $this->view('admin/payment/methods/create', ['errors' => $data['errors']]);
            }
        }
        $this->view('admin/payment/methods/create');
  }

  public function editMethod($id) {
    // Get the payment method by ID
    $paymentMethod = $this->paymentMethodModel->findById($id);
    
    // Check if payment method exists
    if (!$paymentMethod) {
        $this->setFlashMessage('error', 'Phương thức thanh toán không tồn tại');
        $this->redirect(UrlHelper::route('/admin/payment/methods'));
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and update payment method
        $data = $this->validateMethodData($_POST);
        
        if (!isset($data['errors'])) {
            // Handle logo upload or removal
            if (isset($_FILES['logo']) && $_FILES['logo']['size'] > 0) {
                // Process new logo upload
                $logoPath = $this->uploadLogo($_FILES['logo']);
                if ($logoPath) {
                    $data['logo'] = $logoPath;
                    
                    // Remove old logo if exists
                    if (!empty($paymentMethod['logo'])) {
                        $this->removeLogo($paymentMethod['logo']);
                    }
                }
            } elseif (isset($_POST['remove_logo']) && $_POST['remove_logo'] == 1) {
                // Remove existing logo
                if (!empty($paymentMethod['logo'])) {
                    $this->removeLogo($paymentMethod['logo']);
                }
                $data['logo'] = null;
            } else {
                // Keep existing logo
                unset($data['logo']);
            }
            
            // Set is_active to 0 if not checked
            $data['is_active'] = isset($_POST['is_active']) ? 1 : 0;
            
            // Update payment method
            $this->paymentMethodModel->update($id, $data);
            $this->setFlashMessage('success', 'Phương thức thanh toán đã được cập nhật thành công');
            $this->redirect(UrlHelper::route('/admin/payment/methods'));
        }
        
        return $this->view('admin/payment/methods/edit', [
            'paymentMethod' => $paymentMethod,
            'errors' => $data['errors']
        ]);
    }
    
    // Display edit form
    $this->view('admin/payment/methods/edit', ['paymentMethod' => $paymentMethod]);
  }

  /**
   * Toggle payment method active status
   * 
   * @param int $id Payment method ID
   * @return void
   */
  public function toggleMethod($id) {
    // Check if the request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->setFlashMessage('error', 'Phương thức không được hỗ trợ');
        $this->redirect(UrlHelper::route('admin/payment/methods'));
        return;
    }

    // Validate CSRF token first for security
    $this->validateCSRFToken();

    // Get payment method
    $paymentMethod = $this->paymentMethodModel->findById($id);
    
    if (!$paymentMethod) {
        $this->setFlashMessage('error', 'Phương thức thanh toán không tồn tại');
        $this->redirect(UrlHelper::route('admin/payment/methods'));
        return;
    }
    
    // Get new status (opposite of current status)
    $newStatus = $paymentMethod['is_active'] ? 0 : 1;
    
    // If we're trying to deactivate a method, check if it's the only active one
    if ($newStatus === 0) {
        // Count active payment methods
        $activeCount = count($this->paymentMethodModel->getAllActive());
        
        // If this is the only active method, prevent deactivation
        if ($activeCount <= 1) {
            $this->setFlashMessage(
                'error', 
                'Không thể vô hiệu hóa phương thức thanh toán này. Hệ thống phải có ít nhất một phương thức thanh toán hoạt động.'
            );
            $this->redirect(UrlHelper::route('admin/payment/methods'));
            return;
        }
    }
    
    // Update status
    $result = $this->paymentMethodModel->toggleStatus($id, $newStatus);
    
    if ($result) {
        $statusText = $newStatus ? 'kích hoạt' : 'vô hiệu hóa';
        $this->setFlashMessage(
            'success', 
            'Phương thức thanh toán đã được ' . $statusText . ' thành công'
        );
        
        // Log activity
        if (isset($this->activityLogModel)) {
            $this->activityLogModel->log(
                'payment_method',
                $id,
                'Phương thức thanh toán đã được ' . $statusText
            );
        }
    } else {
        $this->setFlashMessage(
            'error', 
            'Không thể thay đổi trạng thái phương thức thanh toán'
        );
    }
    
    // Redirect back to payment methods list
    $this->redirect(UrlHelper::route('admin/payment/methods'));
}
  /**
   * Upload logo file
   * 
   * @param array $file The uploaded file data
   * @return string|false The path to the uploaded file or false on failure
   */
  private function uploadLogo($file) {
      $uploadDir = 'uploads/payment-methods/';
      
      // Create directory if it doesn't exist
      if (!file_exists($uploadDir)) {
          mkdir($uploadDir, 0755, true);
      }
      
      // Generate unique filename
      $filename = uniqid() . '_' . basename($file['name']);
      $targetPath = $uploadDir . $filename;
      
      // Check file type
      $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
      if (!in_array($file['type'], $allowedTypes)) {
          $this->setFlashMessage('error', 'Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF, SVG)');
          return false;
      }
      
      // Check file size (max 2MB)
      if ($file['size'] > 2 * 1024 * 1024) {
          $this->setFlashMessage('error', 'Kích thước file không được vượt quá 2MB');
          return false;
      }
      
      // Move uploaded file
      if (move_uploaded_file($file['tmp_name'], $targetPath)) {
          return '/' . $targetPath;
      }
      
      $this->setFlashMessage('error', 'Không thể tải lên logo. Vui lòng thử lại.');
      return false;
  }

  /**
   * Remove logo file
   * 
   * @param string $logoPath The path to the logo file
   * @return bool True on success, false on failure
   */
  private function removeLogo($logoPath) {
      // Remove leading slash if exists
      $logoPath = ltrim($logoPath, '/');
      
      if (file_exists($logoPath)) {
          return unlink($logoPath);
      }
      
      return false;
  }
  private function validateMethodData($data) {
    $errors = [];
    
    if (empty($data['name'])) {
        $errors['name'] = 'Tên phương thức thanh toán không được để trống';
    }
    
    if (empty($data['code'])) {
        $errors['code'] = 'Mã phương thức không được để trống';
    }
    
    if (!empty($errors)) {
        return ['errors' => $errors];
    }
    
    return [
        'name' => $data['name'],
        'code' => $data['code'],
        'description' => $data['description'] ?? '',
        'instructions' => $data['instructions'] ?? '',
        'is_active' => isset($data['is_active']) ? 1 : 0,
        'config' => json_encode($data['config'] ?? [])
    ];
  }
  // private function validateRefundData($data) {
  //   $errors = [];
    
  //   if (empty($data['transaction_id'])) {
  //       $errors['transaction_id'] = 'ID giao dịch không được để trống';
  //   }
    
  //   if (empty($data['amount'])) {
  //       $errors['amount'] = 'Số tiền hoàn trả không được để trống';
  //   }
    
  //   if (!empty($errors)) {
  //       return ['errors' => $errors];
  //   }
    
  //   return [
  //       'transaction_id' => $data['transaction_id'],
  //       'amount' => $data['amount'],
  //       'reason' => $data['reason'] ?? '',
  //       'status' => 'pending'
  //   ];
  // }
}