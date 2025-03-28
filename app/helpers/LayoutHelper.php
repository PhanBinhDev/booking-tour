<?php
namespace App\Helpers;

class LayoutHelper {
    /**
     * Chọn layout dựa trên vai trò người dùng
     * 
     * @param array $data Dữ liệu view
     * @return string Path đến layout file
     */
    public static function getLayoutByRole($data = []) {
        $role = $_SESSION['role'] ?? 'user';

        // Kiểm tra phiên đăng nhập
        if (!isset($_SESSION['user_id'])) {
            return ROOT_PATH . '/app/views/layouts/base.php';
        }

        // Xác định layout dựa trên vai trò
        switch ($role) {
            case 'admin':
                return ROOT_PATH . '/app/views/layouts/admin_layout.php';
            case 'moderator':
                return ROOT_PATH . '/app/views/layouts/moderator_layout.php';
            case 'user':
            default:
                return ROOT_PATH . '/app/views/layouts/user_layout.php';
        }
    }
}