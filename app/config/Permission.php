<?php
/**
 * File: permissions.php
 * Định nghĩa tất cả các permission trong hệ thống
 */

// Dashboard permissions
define('PERM_VIEW_DASHBOARD', 'view_dashboard');
define('PERM_VIEW_STATISTICS', 'view_statistics');

// User management permissions
define('PERM_VIEW_USERS', 'view_users');
define('PERM_CREATE_USERS', 'create_users');
define('PERM_EDIT_USERS', 'edit_users');
define('PERM_DELETE_USERS', 'delete_users');
define('PERM_MANAGE_ROLES', 'manage_roles');

// Tour management permissions
define('PERM_VIEW_TOURS', 'view_tours');
define('PERM_CREATE_TOURS', 'create_tours');
define('PERM_EDIT_TOURS', 'edit_tours');
define('PERM_DELETE_TOURS', 'delete_tours');
define('PERM_MANAGE_TOUR_CATEGORIES', 'manage_tour_categories');
define('PERM_MANAGE_LOCATIONS', 'manage_locations');
define('PERM_VIEW_BOOKINGS', 'view_bookings');
define('PERM_MANAGE_BOOKINGS', 'manage_bookings');

// Content management permissions
define('PERM_VIEW_NEWS', 'view_news');
define('PERM_CREATE_NEWS', 'create_news');
define('PERM_EDIT_NEWS', 'edit_news');
define('PERM_DELETE_NEWS', 'delete_news');
define('PERM_MANAGE_NEWS_CATEGORIES', 'manage_news_categories');
define('PERM_MANAGE_TAGS', 'manage_tags');

// Comment management permissions
define('PERM_VIEW_COMMENTS', 'view_comments');
define('PERM_MODERATE_COMMENTS', 'moderate_comments');
define('PERM_DELETE_COMMENTS', 'delete_comments');

// Review management permissions
define('PERM_VIEW_REVIEWS', 'view_reviews');
define('PERM_MODERATE_REVIEWS', 'moderate_reviews');
define('PERM_DELETE_REVIEWS', 'delete_reviews');

// Media management permissions
define('PERM_VIEW_IMAGES', 'view_images');
define('PERM_UPLOAD_IMAGES', 'upload_images');
define('PERM_DELETE_IMAGES', 'delete_images');
define('PERM_MANAGE_BANNERS', 'manage_banners');

// Contact management permissions
define('PERM_VIEW_CONTACTS', 'view_contacts');
define('PERM_REPLY_CONTACTS', 'reply_contacts');
define('PERM_DELETE_CONTACTS', 'delete_contacts');

// System permissions
define('PERM_MANAGE_SETTINGS', 'manage_settings');
define('PERM_VIEW_LOGS', 'view_logs');
define('PERM_MANAGE_BACKUPS', 'manage_backups');

/**
 * Nhóm các permission theo danh mục
 */
$PERMISSION_GROUPS = [
    'dashboard' => [
        PERM_VIEW_DASHBOARD,
        PERM_VIEW_STATISTICS
    ],
    'user_management' => [
        PERM_VIEW_USERS,
        PERM_CREATE_USERS,
        PERM_EDIT_USERS,
        PERM_DELETE_USERS,
        PERM_MANAGE_ROLES
    ],
    'tour_management' => [
        PERM_VIEW_TOURS,
        PERM_CREATE_TOURS,
        PERM_EDIT_TOURS,
        PERM_DELETE_TOURS,
        PERM_MANAGE_TOUR_CATEGORIES,
        PERM_MANAGE_LOCATIONS,
        PERM_VIEW_BOOKINGS,
        PERM_MANAGE_BOOKINGS
    ],
    'content_management' => [
        PERM_VIEW_NEWS,
        PERM_CREATE_NEWS,
        PERM_EDIT_NEWS,
        PERM_DELETE_NEWS,
        PERM_MANAGE_NEWS_CATEGORIES,
        PERM_MANAGE_TAGS
    ],
    'comment_management' => [
        PERM_VIEW_COMMENTS,
        PERM_MODERATE_COMMENTS,
        PERM_DELETE_COMMENTS
    ],
    'review_management' => [
        PERM_VIEW_REVIEWS,
        PERM_MODERATE_REVIEWS,
        PERM_DELETE_REVIEWS
    ],
    'media_management' => [
        PERM_VIEW_IMAGES,
        PERM_UPLOAD_IMAGES,
        PERM_DELETE_IMAGES,
        PERM_MANAGE_BANNERS
    ],
    'contact_management' => [
        PERM_VIEW_CONTACTS,
        PERM_REPLY_CONTACTS,
        PERM_DELETE_CONTACTS
    ],
    'system' => [
        PERM_MANAGE_SETTINGS,
        PERM_VIEW_LOGS,
        PERM_MANAGE_BACKUPS
    ]
];

/**
 * Lấy tên hiển thị của permission
 * 
 * @param string $permission Tên permission
 * @return string Tên hiển thị
 */
function getPermissionDisplayName($permission) {
    $displayNames = [
        // Dashboard
        PERM_VIEW_DASHBOARD => 'Xem Dashboard',
        PERM_VIEW_STATISTICS => 'Xem Thống kê',
        
        // User management
        PERM_VIEW_USERS => 'Xem Người dùng',
        PERM_CREATE_USERS => 'Tạo Người dùng',
        PERM_EDIT_USERS => 'Sửa Người dùng',
        PERM_DELETE_USERS => 'Xóa Người dùng',
        PERM_MANAGE_ROLES => 'Quản lý Vai trò & Quyền',
        
        // Tour management
        PERM_VIEW_TOURS => 'Xem Tour',
        PERM_CREATE_TOURS => 'Tạo Tour',
        PERM_EDIT_TOURS => 'Sửa Tour',
        PERM_DELETE_TOURS => 'Xóa Tour',
        PERM_MANAGE_TOUR_CATEGORIES => 'Quản lý Danh mục Tour',
        PERM_MANAGE_LOCATIONS => 'Quản lý Địa điểm',
        PERM_VIEW_BOOKINGS => 'Xem Đặt tour',
        PERM_MANAGE_BOOKINGS => 'Quản lý Đặt tour',
        
        // Content management
        PERM_VIEW_NEWS => 'Xem Tin tức',
        PERM_CREATE_NEWS => 'Tạo Tin tức',
        PERM_EDIT_NEWS => 'Sửa Tin tức',
        PERM_DELETE_NEWS => 'Xóa Tin tức',
        PERM_MANAGE_NEWS_CATEGORIES => 'Quản lý Danh mục Tin tức',
        PERM_MANAGE_TAGS => 'Quản lý Thẻ',
        
        // Comment management
        PERM_VIEW_COMMENTS => 'Xem Bình luận',
        PERM_MODERATE_COMMENTS => 'Duyệt Bình luận',
        PERM_DELETE_COMMENTS => 'Xóa Bình luận',
        
        // Review management
        PERM_VIEW_REVIEWS => 'Xem Đánh giá',
        PERM_MODERATE_REVIEWS => 'Duyệt Đánh giá',
        PERM_DELETE_REVIEWS => 'Xóa Đánh giá',
        
        // Media management
        PERM_VIEW_IMAGES => 'Xem Hình ảnh',
        PERM_UPLOAD_IMAGES => 'Tải lên Hình ảnh',
        PERM_DELETE_IMAGES => 'Xóa Hình ảnh',
        PERM_MANAGE_BANNERS => 'Quản lý Banner',
        
        // Contact management
        PERM_VIEW_CONTACTS => 'Xem Liên hệ',
        PERM_REPLY_CONTACTS => 'Trả lời Liên hệ',
        PERM_DELETE_CONTACTS => 'Xóa Liên hệ',
        
        // System
        PERM_MANAGE_SETTINGS => 'Quản lý Cài đặt',
        PERM_VIEW_LOGS => 'Xem Nhật ký',
        PERM_MANAGE_BACKUPS => 'Quản lý Sao lưu'
    ];
    
    return isset($displayNames[$permission]) ? $displayNames[$permission] : $permission;
}

/**
 * Lấy tên hiển thị của nhóm permission
 * 
 * @param string $group Tên nhóm
 * @return string Tên hiển thị
 */
function getPermissionGroupDisplayName($group) {
    $displayNames = [
        'dashboard' => 'Dashboard',
        'user_management' => 'Quản lý Người dùng',
        'tour_management' => 'Quản lý Tour',
        'content_management' => 'Quản lý Nội dung',
        'comment_management' => 'Quản lý Bình luận',
        'review_management' => 'Quản lý Đánh giá',
        'media_management' => 'Quản lý Media',
        'contact_management' => 'Quản lý Liên hệ',
        'system' => 'Hệ thống'
    ];
    
    return isset($displayNames[$group]) ? $displayNames[$group] : $group;
}

/**
 * Kiểm tra người dùng có quyền không
 * 
 * @param int $userId ID người dùng
 * @param string $permission Tên quyền cần kiểm tra
 * @return bool Có quyền hay không
 */
function hasPermission($userId, $permission) {
    global $db;
    
    $stmt = $db->prepare("
        SELECT COUNT(*) FROM users u
        JOIN role_permissions rp ON u.role_id = rp.role_id
        JOIN permissions p ON rp.permission_id = p.id
        WHERE u.id = ? AND p.name = ? AND u.status = 'active'
    ");
    
    $stmt->execute([$userId, $permission]);
    return $stmt->fetchColumn() > 0;
}

/**
 * Lấy tất cả quyền của người dùng
 * 
 * @param int $userId ID người dùng
 * @return array Danh sách quyền
 */
function getUserPermissions($userId) {
    global $db;
    
    $stmt = $db->prepare("
        SELECT p.name FROM users u
        JOIN role_permissions rp ON u.role_id = rp.role_id
        JOIN permissions p ON rp.permission_id = p.id
        WHERE u.id = ? AND u.status = 'active'
    ");
    
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}