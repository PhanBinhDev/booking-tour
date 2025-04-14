<?php

namespace App\Controllers;

use App\Helpers\LayoutHelper;
use App\Helpers\SessionHelper;
use App\Helpers\UrlHelper;

class BaseController
{

    public function __construct()
    {
        // Kiểm tra và điều hướng admin nếu cần
        if ($this->isAdmin()) {
            $requestPath = $_SERVER['REQUEST_URI'];
            $basePath = parse_url($requestPath, PHP_URL_PATH);

            // Kiểm tra nếu đường dẫn không bắt đầu bằng /admin và không phải là route logout
            if (strpos($basePath, "/admin") !== 0 && strpos($basePath, "/auth/logout") !== 0) {
                $this->redirect(UrlHelper::route('admin/dashboard'));
            }
        }
    }

    /**
     * Build a pagination URL preserving all current query parameters
     * 
     * @param int $page The page number to link to
     * @return string The URL with page parameter and all other current query parameters
     */
    protected function buildPaginationUrl($page)
    {
        $params = $_GET;
        $params['page'] = $page;

        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
        return $currentUrl . '?' . http_build_query($params);
    }
    /**
     * Tạo CSRF token và lưu vào session
     * 
     * @return string CSRF token
     */
    protected function createCSRFToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
        return $_SESSION['csrf_token'];
    }

    /**
     * Xác thực CSRF token
     * 
     * @param bool $redirect Có chuyển hướng nếu token không hợp lệ hay không
     * @return bool Trả về true nếu token hợp lệ, ngược lại trả về false
     */
    protected function validateCSRFToken($redirect = true)
    {
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            if ($redirect) {
                $this->redirect($_SERVER['HTTP_REFERER'] ?? UrlHelper::route(''), 'Phiên làm việc đã hết hạn hoặc yêu cầu không hợp lệ', 'error');
            }
            return false;
        }

        // Tạo token mới sau khi xác thực thành công để ngăn chặn tấn công CSRF kiểu replay
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return true;
    }

    /**
     * Đặt thông báo flash
     * 
     * @param string $type Loại thông báo
     * @param string $message Nội dung thông báo
     */
    function setFlashMessage($type, $message)
    {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public function view($view, $data = [], $layoutBase = null)
    {

        // Thiết lập layout mặc định nếu không được chỉ định
        if (!$layoutBase) {
            $layout = LayoutHelper::getLayoutByRole();
        }

        // Trích xuất dữ liệu thành các biến riêng lẻ
        extract($data);

        $viewPath = ROOT_PATH . '/app/views/' . $view . '.php';

        // Bắt đầu output buffering để capture nội dung view
        ob_start();
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            // Nếu view không tồn tại, hiển thị trang not found
            include ROOT_PATH . '/app/views/errors/404.php';
        }
        $content = ob_get_clean();

        if (!file_exists($layout)) {
            die("Layout not found at {$layout}");
        }

        // Load layout với nội dung từ view
        require $layout;
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public function isAdmin()
    {
        return $this->isAuthenticated() && $this->getRole() === 'admin';
    }
    public function redirectByRole()
    {
        $redirectUrl = $this->getRouteByRole();
        $this->redirect($redirectUrl);
    }

    public function getRouteByRole()
    {
        $role = SessionHelper::get('role') ?? 'user';
        switch ($role) {
            case 'admin':
                return UrlHelper::route('admin/dashboard');
            case 'moderator':
                return UrlHelper::route('moderator/dashboard');
            case 'user':
            default:
                return UrlHelper::route('');
        }
    }

    public function json($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    public function isAuthenticated()
    {
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser()
    {
        if (isset($_SESSION['user_id'])) {
            $userModel = new \App\Models\User();
            return $userModel->getUserWithRole($_SESSION['user_id']);
        }
        return null;
    }

    public function checkPermission($permission)
    {
        if (!$this->isAuthenticated()) {
            return false;
        }

        $userModel = new \App\Models\User();
        return $userModel->hasPermission($_SESSION['user_id'], $permission);
    }

    public function getRole()
    {
        return SessionHelper::get('role') ?? 'user';
    }
}