-- -----------------------------------------------------
-- Database schema for Di Travel
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE TABLE `roles`(
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `permissions`
-- -----------------------------------------------------
CREATE TABLE `permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT,
  `category` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `role_permissions`
-- -----------------------------------------------------
CREATE TABLE `role_permissions` (
  `role_id` INT NOT NULL,
  `permission_id` INT NOT NULL,
  PRIMARY KEY (`role_id`, `permission_id`),
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100),
  `phone` VARCHAR(20),
  `address` TEXT,
  `avatar` VARCHAR(255),
  `role_id` INT NOT NULL,
  `status` ENUM('active', 'inactive', 'banned') DEFAULT 'active',
  `email_verified` BOOLEAN DEFAULT FALSE,
  `verification_token` VARCHAR(255),
  `reset_token` VARCHAR(255),
  `reset_token_expires` DATETIME,
  `last_login` DATETIME,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);

-- -----------------------------------------------------
-- Table `user_profiles`
-- -----------------------------------------------------
CREATE TABLE `user_profiles` (
  `user_id` INT PRIMARY KEY,
  `bio` TEXT,
  `date_of_birth` DATE,
  `gender` ENUM('male', 'female', 'other'),
  `website` VARCHAR(255),
  `facebook` VARCHAR(255),
  `twitter` VARCHAR(255),
  `instagram` VARCHAR(255),
  `preferences` JSON,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `tour_categories`
-- -----------------------------------------------------
CREATE TABLE `tour_categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `description` TEXT,
  `image` VARCHAR(255),
  `parent_id` INT,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`parent_id`) REFERENCES `tour_categories` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `locations`
-- -----------------------------------------------------
CREATE TABLE `locations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `description` TEXT,
  `image` VARCHAR(255),
  `country` VARCHAR(100),
  `region` VARCHAR(100),
  `latitude` DECIMAL(10,8),
  `longitude` DECIMAL(11,8),
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- -----------------------------------------------------
-- Table `images`
-- -----------------------------------------------------
CREATE TABLE `images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255),
  `description` TEXT,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_size` INT,
  `file_type` VARCHAR(50),
  `width` INT,
  `height` INT,
  `alt_text` VARCHAR(255),
  `cloudinary_id` VARCHAR(255),
  `cloudinary_url` VARCHAR(255),
  `user_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `tours`
-- -----------------------------------------------------
CREATE TABLE `tours` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT,
  `content` LONGTEXT,
  `duration` VARCHAR(50),
  `group_size` VARCHAR(50),
  `price` DECIMAL(10,2) NOT NULL,
  `sale_price` DECIMAL(10,2),
  `category_id` INT,
  `location_id` INT,
  `departure_location_id` INT,
  `included` TEXT,
  `excluded` TEXT,
  `itinerary` JSON,
  `meta_title` VARCHAR(255),
  `meta_description` TEXT,
  `status` ENUM('active', 'inactive', 'draft') DEFAULT 'active',
  `featured` BOOLEAN DEFAULT FALSE,
  `views` INT DEFAULT 0,
  `created_by` INT NOT NULL,
  `updated_by` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `tour_categories` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`departure_location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `tour_images`
-- -----------------------------------------------------
CREATE TABLE `tour_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tour_id` INT NOT NULL,
  `image_id` INT NOT NULL,
  `is_featured` BOOLEAN DEFAULT FALSE,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE
);
-- -----------------------------------------------------
-- Table `tour_dates`
-- -----------------------------------------------------
CREATE TABLE `tour_dates` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tour_id` INT NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `price` DECIMAL(10,2),
  `sale_price` DECIMAL(10,2),
  `available_seats` INT,
  `status` ENUM('available', 'full', 'cancelled') DEFAULT 'available',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `bookings`
-- -----------------------------------------------------
CREATE TABLE `bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_number` VARCHAR(50) NOT NULL UNIQUE,
  `user_id` INT,
  `tour_id` INT NOT NULL,
  `tour_date_id` INT,
  `adults` INT NOT NULL DEFAULT 1,
  `children` INT DEFAULT 0,
  `total_price` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'confirmed', 'paid', 'cancelled', 'completed') DEFAULT 'pending',
  `payment_status` ENUM('pending', 'paid', 'refunded', 'failed') DEFAULT 'pending',
  `payment_method` VARCHAR(50),
  `transaction_id` VARCHAR(255),
  `special_requirements` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tour_date_id`) REFERENCES `tour_dates` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `booking_customers`
-- -----------------------------------------------------
CREATE TABLE `booking_customers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100),
  `phone` VARCHAR(20),
  `address` TEXT,
  `passport_number` VARCHAR(50),
  `date_of_birth` DATE,
  `nationality` VARCHAR(50),
  `type` ENUM('adult', 'child') DEFAULT 'adult',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `tour_reviews`
-- -----------------------------------------------------
CREATE TABLE `tour_reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tour_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `booking_id` INT,
  `rating` TINYINT NOT NULL,
  `title` VARCHAR(255),
  `review` TEXT,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `news_categories`
-- -----------------------------------------------------
CREATE TABLE `news_categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `description` TEXT,
  `image` VARCHAR(255),
  `parent_id` INT,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`parent_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `news`
-- -----------------------------------------------------
CREATE TABLE `news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `summary` TEXT,
  `content` LONGTEXT,
  `featured_image` VARCHAR(255),
  `category_id` INT,
  `meta_title` VARCHAR(255),
  `meta_description` TEXT,
  `status` ENUM('published', 'draft', 'archived') DEFAULT 'published',
  `featured` BOOLEAN DEFAULT FALSE,
  `views` INT DEFAULT 0,
  `created_by` INT NOT NULL,
  `updated_by` INT,
  `published_at` DATETIME,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `news_tags`
-- -----------------------------------------------------
CREATE TABLE `news_tags` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `slug` VARCHAR(60) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `news_tag_relations`
-- -----------------------------------------------------
CREATE TABLE `news_tag_relations` (
  `news_id` INT NOT NULL,
  `tag_id` INT NOT NULL,
  PRIMARY KEY (`news_id`, `tag_id`),
  FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tag_id`) REFERENCES `news_tags` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `comments`
-- -----------------------------------------------------
CREATE TABLE `comments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `content` TEXT NOT NULL,
  `user_id` INT,
  `parent_id` INT,
  `entity_type` ENUM('news', 'tour') NOT NULL,
  `entity_id` INT NOT NULL,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
);



-- -----------------------------------------------------
-- Table `banners`
-- -----------------------------------------------------
CREATE TABLE `banners` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `image_id` INT NOT NULL,
  `link` VARCHAR(255),
  `position` VARCHAR(50) NOT NULL,
  `start_date` DATE,
  `end_date` DATE,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `sort_order` INT DEFAULT 0,
  `created_by` INT NOT NULL,
  `updated_by` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `contacts`
-- -----------------------------------------------------
CREATE TABLE `contacts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20),
  `subject` VARCHAR(255),
  `message` TEXT NOT NULL,
  `status` ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
  `ip_address` VARCHAR(45),
  `user_agent` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `settings`
-- -----------------------------------------------------
CREATE TABLE `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(100) NOT NULL UNIQUE,
  `value` TEXT,
  `type` VARCHAR(50) DEFAULT 'text',
  `group` VARCHAR(50) DEFAULT 'general',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `activity_logs`
-- -----------------------------------------------------
CREATE TABLE `activity_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `action` VARCHAR(255) NOT NULL,
  `entity_type` VARCHAR(50),
  `entity_id` INT,
  `description` TEXT,
  `ip_address` VARCHAR(45),
  `user_agent` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
);


-- -----------------------------------------------------
-- Table `payment_methods`
-- -----------------------------------------------------
CREATE TABLE `payment_methods` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT,
  `instructions` TEXT,
  `logo` VARCHAR(255),
  `config` JSON,
  `is_online` BOOLEAN DEFAULT TRUE,
  `sort_order` INT DEFAULT 0,
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `payments`
-- -----------------------------------------------------
CREATE TABLE `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `payment_method_id` INT NOT NULL,
  `transaction_id` VARCHAR(255),
  `amount` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(10) DEFAULT 'VND',
  `status` ENUM('pending', 'processing', 'completed', 'failed', 'refunded', 'cancelled') DEFAULT 'pending',
  `payment_data` JSON,
  `notes` TEXT,
  `payer_name` VARCHAR(100),
  `payer_email` VARCHAR(100),
  `payer_phone` VARCHAR(20),
  `payment_date` DATETIME,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE RESTRICT
);

-- -----------------------------------------------------
-- Table `payment_logs`
-- -----------------------------------------------------
CREATE TABLE `payment_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `payment_id` INT,
  `booking_id` INT,
  `event` VARCHAR(50) NOT NULL,
  `status` VARCHAR(50),
  `message` TEXT,
  `data` JSON,
  `ip_address` VARCHAR(45),
  `user_agent` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `invoices`
-- -----------------------------------------------------
CREATE TABLE `invoices` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `invoice_number` VARCHAR(50) NOT NULL UNIQUE,
  `booking_id` INT NOT NULL,
  `payment_id` INT,
  `user_id` INT,
  `amount` DECIMAL(10,2) NOT NULL,
  `tax_amount` DECIMAL(10,2) DEFAULT 0,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `status` ENUM('draft', 'issued', 'paid', 'cancelled', 'refunded') DEFAULT 'draft',
  `issue_date` DATE,
  `due_date` DATE,
  `paid_date` DATE,
  `notes` TEXT,
  `billing_name` VARCHAR(100),
  `billing_address` TEXT,
  `billing_email` VARCHAR(100),
  `billing_phone` VARCHAR(20),
  `tax_code` VARCHAR(50),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Dữ liệu mẫu cho phương thức thanh toán
-- -----------------------------------------------------
INSERT INTO `payment_methods` (`name`, `code`, `description`, `instructions`, `is_online`, `sort_order`) VALUES
('Chuyển khoản ngân hàng', 'bank_transfer', 'Thanh toán bằng cách chuyển khoản qua ngân hàng', 'Vui lòng chuyển khoản đến số tài khoản: 123456789 - Ngân hàng ABC - Chi nhánh XYZ', FALSE, 1),
('Thanh toán khi nhận tour', 'cash', 'Thanh toán bằng tiền mặt khi bắt đầu tour', 'Vui lòng chuẩn bị đủ số tiền khi bắt đầu tour', FALSE, 2),
('VNPay', 'vnpay', 'Thanh toán trực tuyến qua cổng VNPay', NULL, TRUE, 3),
('Momo', 'momo', 'Thanh toán qua ví điện tử Momo', NULL, TRUE, 4),
('PayPal', 'paypal', 'Thanh toán quốc tế qua PayPal', NULL, TRUE, 5);


-- -----------------------------------------------------
-- Insert default roles
-- -----------------------------------------------------
INSERT INTO `roles` (`name`, `description`) VALUES 
('admin', 'Administrator with full access to all features'),
('moderator', 'Moderator with content management permissions'),
('editor', 'Editor with permissions to create and edit content'),
('user', 'Regular user with basic permissions');

-- -----------------------------------------------------
-- Insert permissions by category
-- -----------------------------------------------------

-- Dashboard permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('view_dashboard', 'Can view dashboard', 'dashboard'),
('view_statistics', 'Can view statistics', 'dashboard');

-- User management permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('view_users', 'Can view users', 'user_management'),
('create_users', 'Can create users', 'user_management'),
('edit_users', 'Can edit users', 'user_management'),
('delete_users', 'Can delete users', 'user_management'),
('manage_roles', 'Can manage roles and permissions', 'user_management');

-- Tour management permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('view_tours', 'Can view tours', 'tour_management'),
('create_tours', 'Can create tours', 'tour_management'),
('edit_tours', 'Can edit tours', 'tour_management'),
('delete_tours', 'Can delete tours', 'tour_management'),
('manage_tour_categories', 'Can manage tour categories', 'tour_management'),
('manage_locations', 'Can manage locations', 'tour_management'),
('view_bookings', 'Can view bookings', 'tour_management'),
('manage_bookings', 'Can manage bookings', 'tour_management');

-- Content management permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('view_news', 'Can view news articles', 'content_management'),
('create_news', 'Can create news articles', 'content_management'),
('edit_news', 'Can edit news articles', 'content_management'),
('delete_news', 'Can delete news articles', 'content_management'),
('manage_news_categories', 'Can manage news categories', 'content_management'),
('manage_tags', 'Can manage tags', 'content_management');

-- Comment management permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('view_comments', 'Can view comments', 'comment_management'),
('moderate_comments', 'Can moderate comments', 'comment_management'),
('delete_comments', 'Can delete comments', 'comment_management');

-- Review management permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('view_reviews', 'Can view reviews', 'review_management'),
('moderate_reviews', 'Can moderate reviews', 'review_management'),
('delete_reviews', 'Can delete reviews', 'review_management');

-- Media management permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('view_images', 'Can view images', 'media_management'),
('upload_images', 'Can upload images', 'media_management'),
('delete_images', 'Can delete images', 'media_management'),
('manage_banners', 'Can manage banners', 'media_management');

-- Contact management permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('view_contacts', 'Can view contact messages', 'contact_management'),
('reply_contacts', 'Can reply to contact messages', 'contact_management'),
('delete_contacts', 'Can delete contact messages', 'contact_management');

-- System permissions
INSERT INTO `permissions` (`name`, `description`, `category`) VALUES
('manage_settings', 'Can manage system settings', 'system'),
('view_logs', 'Can view system logs', 'system'),
('manage_backups', 'Can manage backups', 'system');

-- -----------------------------------------------------
-- Assign permissions to roles
-- -----------------------------------------------------

-- Admin role - all permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 1, id FROM `permissions`;

-- Moderator role permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 2, id FROM `permissions` 
WHERE `name` IN (
  'view_dashboard', 'view_statistics',
  'view_users',
  'view_tours', 'edit_tours', 'manage_tour_categories',
  'view_news', 'create_news', 'edit_news', 'manage_news_categories',
  'view_comments', 'moderate_comments', 'delete_comments',
  'view_reviews', 'moderate_reviews',
  'view_images', 'upload_images', 'manage_banners',
  'view_contacts', 'reply_contacts',
  'view_logs'
);

-- Editor role permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 3, id FROM `permissions` 
WHERE `name` IN (
  'view_dashboard',
  'view_tours', 'create_tours', 'edit_tours',
  'view_news', 'create_news', 'edit_news',
  'view_comments',
  'view_reviews',
  'view_images', 'upload_images',
  'view_contacts'
);

-- User role permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 4, id FROM `permissions` 
WHERE `name` IN (
  'view_tours',
  'view_news',
  'upload_images'
);

-- -----------------------------------------------------
-- Insert default settings
-- -----------------------------------------------------
INSERT INTO `settings` (`key`, `value`, `type`, `group`) VALUES
('site_name', 'Di Travel', 'text', 'general'),
('site_description', 'Khám phá thế giới cùng chúng tôi, từng hành trình một', 'textarea', 'general'),
('site_logo', '', 'image', 'general'),
('contact_email', 'info@ditravel.com', 'email', 'contact'),
('contact_phone', '+84 (28) 3822 9999', 'text', 'contact'),
('contact_address', '123 Đường Lê Lợi, Quận 1, TP. Hồ Chí Minh, Việt Nam', 'textarea', 'contact'),
('social_facebook', 'https://facebook.com/ditravel', 'url', 'social'),
('social_instagram', 'https://instagram.com/ditravel', 'url', 'social'),
('social_twitter', 'https://twitter.com/ditravel', 'url', 'social'),
('currency', 'VND', 'text', 'payment'),
('items_per_page', '10', 'number', 'general');

-- -----------------------------------------------------
-- Insert default admin user
-- -----------------------------------------------------
INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `role_id`, `status`, `email_verified`) 
VALUES ('admin', 'admin@ditravel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 1, 'active', TRUE);
-- Password: password