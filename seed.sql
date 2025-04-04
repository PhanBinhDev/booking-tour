-- -----------------------------------------------------
-- Database schema for Di Travel
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS booking_travel;

USE booking_travel;
-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `roles`(
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT,
  `category` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `role_permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` INT NOT NULL,
  `permission_id` INT NOT NULL,
  PRIMARY KEY (`role_id`, `permission_id`),
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
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
CREATE TABLE IF NOT EXISTS `user_profiles` (
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
CREATE TABLE IF NOT EXISTS `tour_categories` (
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
CREATE TABLE IF NOT EXISTS `locations` (
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
CREATE TABLE IF NOT EXISTS `images` (
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
  `category` VARCHAR(50) DEFAULT 'general',
  `user_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `tours`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tours` (
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
CREATE TABLE IF NOT EXISTS `tour_images` (
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
CREATE TABLE IF NOT EXISTS `tour_dates` (
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
CREATE TABLE IF NOT EXISTS `bookings` (
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
  `cancellation_data` JSON DEFAULT NULL
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tour_date_id`) REFERENCES `tour_dates` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `booking_customers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_customers` (
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
CREATE TABLE IF NOT EXISTS `tour_reviews` (
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
CREATE TABLE IF NOT EXISTS `news_categories` (
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
-- Table `news_category_relations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news_category_relations` (
  `news_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`news_id`, `category_id`),
  FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `news`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news` (
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
CREATE TABLE IF NOT EXISTS `news_tags` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `slug` VARCHAR(60) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `news_tag_relations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news_tag_relations` (
  `news_id` INT NOT NULL,
  `tag_id` INT NOT NULL,
  PRIMARY KEY (`news_id`, `tag_id`),
  FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tag_id`) REFERENCES `news_tags` (`id`) ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Table `comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `comments` (
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
CREATE TABLE IF NOT EXISTS `banners` (
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
CREATE TABLE IF NOT EXISTS `contacts` (
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
CREATE TABLE IF NOT EXISTS `settings` (
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
CREATE TABLE IF NOT EXISTS `activity_logs` (
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
CREATE TABLE IF NOT EXISTS `payment_methods` (
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
-- Table `transactions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `transaction_code` VARCHAR(50) NOT NULL UNIQUE,
  `payment_id` INT,
  `amount` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(10) DEFAULT 'VND',
  `status` ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
  `payment_method` VARCHAR(50) NOT NULL,
  `payment_data` JSON,
  `notes` TEXT,
  `customer_name` VARCHAR(100),
  `customer_email` VARCHAR(100),
  `customer_phone` VARCHAR(20),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table `refunds`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `refunds` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `refund_code` VARCHAR(50) NOT NULL UNIQUE,
  `payment_id` INT NOT NULL,
  `transaction_id` INT,
  `amount` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(10) DEFAULT 'VND',
  `status` ENUM('pending', 'processing', 'completed', 'rejected') DEFAULT 'pending',
  `reason` TEXT NOT NULL,
  `refund_data` JSON,
  `notes` TEXT,
  `refunded_by` INT,
  `refund_date` DATETIME,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`refunded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- Table `payments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `payment_method_id` INT NOT NULL,
  `transaction_id` VARCHAR(255),
  `transaction_id_internal` INT,
  `refund_id` INT,
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
  FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`transaction_id_internal`) REFERENCES `transactions` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`refund_id`) REFERENCES `refunds` (`id`) ON DELETE SET NULL
);

-- Add missing foreign key to refunds table
ALTER TABLE `refunds` 
ADD FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

-- -----------------------------------------------------
-- Table `payment_logs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `payment_logs` (
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
CREATE TABLE IF NOT EXISTS `invoices` (
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
-- Table `favorites`
-- -----------------------------------------------------

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) /*T![clustered_index] CLUSTERED */,
  KEY `fk_1` (`user_id`),
  KEY `fk_2` (`tour_id`),
  CONSTRAINT `fk_1` FOREIGN KEY (`user_id`) REFERENCES `booking_travel`.`users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_2` FOREIGN KEY (`tour_id`) REFERENCES `booking_travel`.`tours` (`id`) ON DELETE CASCADE
);


-- -----------------------------------------------------
-- Table `news_category_relations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news_category_relations` (
  `news_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`news_id`, `category_id`),
  FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE
);

-- Update transactions foreign key to reference payments
UPDATE `transactions` SET `payment_id` = NULL;
ALTER TABLE `transactions` 
ADD FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL;


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



-- -----------------------------------------------------
-- MOCK DATA
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Mock data for tour_categories
-- -----------------------------------------------------
INSERT INTO `tour_categories` (`name`, `slug`, `description`, `status`) VALUES
('Tour trong nước', 'tour-trong-nuoc', 'Các tour du lịch trong nước Việt Nam', 'active'),
('Tour nước ngoài', 'tour-nuoc-ngoai', 'Các tour du lịch quốc tế', 'active'),
('Tour nghỉ dưỡng', 'tour-nghi-duong', 'Các tour nghỉ dưỡng cao cấp', 'active'),
('Tour mạo hiểm', 'tour-mao-hiem', 'Các tour mạo hiểm và thể thao', 'active'),
('Tour văn hóa', 'tour-van-hoa', 'Các tour khám phá văn hóa', 'active');

-- -----------------------------------------------------
-- Mock data for locations
-- -----------------------------------------------------
INSERT INTO `locations` (`name`, `slug`, `description`, `country`, `region`, `latitude`, `longitude`, `status`) VALUES
('Hà Nội', 'ha-noi', 'Thủ đô Hà Nội', 'Việt Nam', 'Miền Bắc', 21.0285, 105.8542, 'active'),
('Đà Nẵng', 'da-nang', 'Thành phố Đà Nẵng', 'Việt Nam', 'Miền Trung', 16.0544, 108.2022, 'active'),
('Hồ Chí Minh', 'ho-chi-minh', 'Thành phố Hồ Chí Minh', 'Việt Nam', 'Miền Nam', 10.8231, 106.6297, 'active'),
('Phú Quốc', 'phu-quoc', 'Đảo Phú Quốc', 'Việt Nam', 'Miền Nam', 10.2179, 103.9570, 'active'),
('Nha Trang', 'nha-trang', 'Thành phố Nha Trang', 'Việt Nam', 'Miền Trung', 12.2388, 109.1967, 'active'),
('Bangkok', 'bangkok', 'Thủ đô Bangkok', 'Thái Lan', 'Đông Nam Á', 13.7563, 100.5018, 'active'),
('Singapore', 'singapore', 'Singapore', 'Singapore', 'Đông Nam Á', 1.3521, 103.8198, 'active'),
('Tokyo', 'tokyo', 'Thủ đô Tokyo', 'Nhật Bản', 'Đông Á', 35.6762, 139.6503, 'active');

-- -----------------------------------------------------
-- Mock data for tours
-- -----------------------------------------------------
INSERT INTO `tours` (`title`, `slug`, `description`, `content`, `duration`, `group_size`, `price`, `sale_price`, `category_id`, `location_id`, `departure_location_id`, `status`, `featured`, `created_by`) VALUES
('Khám phá Hà Nội 3 ngày 2 đêm', 'kham-pha-ha-noi-3-ngay-2-dem', 'Tour khám phá Hà Nội trong 3 ngày 2 đêm', 'Nội dung chi tiết về tour Hà Nội', '3 ngày 2 đêm', '10-20 người', 2500000, 2200000, 1, 1, 3, 'active', TRUE, 1),
('Đà Nẵng - Hội An - Bà Nà Hills', 'da-nang-hoi-an-ba-na-hills', 'Tour Đà Nẵng - Hội An - Bà Nà Hills', 'Nội dung chi tiết về tour Đà Nẵng', '4 ngày 3 đêm', '15-25 người', 3500000, 3200000, 1, 2, 3, 'active', TRUE, 1),
('Phú Quốc nghỉ dưỡng cao cấp', 'phu-quoc-nghi-duong-cao-cap', 'Tour nghỉ dưỡng cao cấp tại Phú Quốc', 'Nội dung chi tiết về tour Phú Quốc', '5 ngày 4 đêm', '2-10 người', 8500000, 7800000, 3, 4, 3, 'active', TRUE, 1),
('Khám phá Tokyo - Osaka - Kyoto', 'kham-pha-tokyo-osaka-kyoto', 'Tour khám phá Nhật Bản', 'Nội dung chi tiết về tour Nhật Bản', '7 ngày 6 đêm', '10-20 người', 25000000, 23500000, 2, 8, 3, 'active', FALSE, 1),
('Singapore - Malaysia 5 ngày', 'singapore-malaysia-5-ngay', 'Tour Singapore và Malaysia', 'Nội dung chi tiết về tour Singapore - Malaysia', '5 ngày 4 đêm', '15-25 người', 12000000, 11500000, 2, 7, 3, 'active', FALSE, 1);

-- -----------------------------------------------------
-- Mock data for tour_dates
-- -----------------------------------------------------
INSERT INTO `tour_dates` (`tour_id`, `start_date`, `end_date`, `price`, `sale_price`, `available_seats`, `status`) VALUES
(1, '2023-06-15', '2023-06-17', 2500000, 2200000, 20, 'available'),
(1, '2023-07-10', '2023-07-12', 2500000, 2200000, 20, 'available'),
(1, '2023-08-05', '2023-08-07', 2700000, 2400000, 20, 'available'),
(2, '2023-06-20', '2023-06-23', 3500000, 3200000, 25, 'available'),
(2, '2023-07-15', '2023-07-18', 3500000, 3200000, 25, 'available'),
(3, '2023-06-25', '2023-06-29', 8500000, 7800000, 10, 'available'),
(3, '2023-07-20', '2023-07-24', 9000000, 8200000, 10, 'available'),
(4, '2023-09-10', '2023-09-16', 25000000, 23500000, 20, 'available'),
(5, '2023-08-15', '2023-08-19', 12000000, 11500000, 25, 'available');

-- -----------------------------------------------------
-- Mock data for bookings
-- -----------------------------------------------------
INSERT INTO `bookings` (`booking_number`, `user_id`, `tour_id`, `tour_date_id`, `adults`, `children`, `total_price`, `status`, `payment_status`, `payment_method`, `special_requirements`, `created_at`) VALUES
('BK-230501', 1, 1, 1, 2, 0, 4400000, 'confirmed', 'paid', 'bank_transfer', 'Không có yêu cầu đặc biệt', '2023-05-01 10:15:30'),
('BK-230502', NULL, 2, 4, 2, 1, 6400000, 'confirmed', 'paid', 'vnpay', 'Cần phòng không hút thuốc', '2023-05-02 14:22:45'),
('BK-230503', NULL, 3, 6, 2, 0, 15600000, 'confirmed', 'paid', 'momo', 'Yêu cầu phòng view biển', '2023-05-03 09:45:12'),
('BK-230504', 1, 4, 8, 2, 0, 47000000, 'pending', 'pending', NULL, 'Cần hỗ trợ visa', '2023-05-04 16:30:00'),
('BK-230505', NULL, 5, 9, 4, 2, 46000000, 'confirmed', 'paid', 'paypal', 'Cần xe đón sân bay', '2023-05-05 11:20:15'),
('BK-230506', NULL, 1, 2, 1, 0, 2200000, 'cancelled', 'refunded', 'bank_transfer', NULL, '2023-05-06 08:45:30'),
('BK-230507', 1, 2, 5, 3, 1, 9600000, 'confirmed', 'paid', 'vnpay', NULL, '2023-05-07 13:10:22'),
('BK-230508', NULL, 3, 7, 2, 0, 16400000, 'pending', 'pending', NULL, NULL, '2023-05-08 15:30:45');

-- -----------------------------------------------------
-- Mock data for booking_customers
-- -----------------------------------------------------
INSERT INTO `booking_customers` (`booking_id`, `full_name`, `email`, `phone`, `address`, `type`) VALUES
(1, 'Nguyễn Văn An', 'nguyenvanan@example.com', '0901234567', 'Quận 1, TP.HCM', 'adult'),
(1, 'Trần Thị Bình', 'tranthib@example.com', '0901234568', 'Quận 1, TP.HCM', 'adult'),
(2, 'Lê Văn Cường', 'levc@example.com', '0901234569', 'Quận 7, TP.HCM', 'adult'),
(2, 'Phạm Thị Dung', 'phamtd@example.com', '0901234570', 'Quận 7, TP.HCM', 'adult'),
(2, 'Lê An Nhiên', NULL, NULL, NULL, 'child'),
(3, 'Hoàng Văn Minh', 'hoangvm@example.com', '0901234571', 'Quận Cầu Giấy, Hà Nội', 'adult'),
(3, 'Nguyễn Thị Lan', 'nguyentl@example.com', '0901234572', 'Quận Cầu Giấy, Hà Nội', 'adult'),
(4, 'Trần Văn Hùng', 'tranvh@example.com', '0901234573', 'Quận 2, TP.HCM', 'adult'),
(4, 'Lê Thị Mai', 'letm@example.com', '0901234574', 'Quận 2, TP.HCM', 'adult'),
(5, 'Phạm Văn Nam', 'phamvn@example.com', '0901234575', 'Quận Đống Đa, Hà Nội', 'adult'),
(5, 'Vũ Thị Oanh', 'vuto@example.com', '0901234576', 'Quận Đống Đa, Hà Nội', 'adult'),
(5, 'Phạm Minh Đức', NULL, NULL, NULL, 'adult'),
(5, 'Phạm Thị Hoa', NULL, NULL, NULL, 'adult'),
(5, 'Phạm An Nhiên', NULL, NULL, NULL, 'child'),
(5, 'Phạm Minh Anh', NULL, NULL, NULL, 'child');

-- -----------------------------------------------------
-- Mock data for payments
-- -----------------------------------------------------
INSERT INTO `payments` (`booking_id`, `payment_method_id`, `transaction_id`, `amount`, `currency`, `status`, `payment_data`, `notes`, `payer_name`, `payer_email`, `payer_phone`, `payment_date`, `created_at`) VALUES
(1, 1, 'BT-230501', 4400000, 'VND', 'completed', '{"bank": "Vietcombank", "account_number": "0123456789"}', 'Thanh toán đầy đủ', 'Nguyễn Văn An', 'nguyenvanan@example.com', '0901234567', '2023-05-01 10:30:45', '2023-05-01 10:15:30'),
(2, 3, 'VNP-230502', 6400000, 'VND', 'completed', '{"vnp_TransactionNo": "13349337", "vnp_BankCode": "NCB"}', NULL, 'Lê Văn Cường', 'levc@example.com', '0901234569', '2023-05-02 14:30:22', '2023-05-02 14:22:45'),
(3, 4, 'MOMO-230503', 15600000, 'VND', 'completed', '{"partnerCode": "MOMO", "orderId": "MM230503", "transId": 2345678}', NULL, 'Hoàng Văn Minh', 'hoangvm@example.com', '0901234571', '2023-05-03 09:55:30', '2023-05-03 09:45:12'),
(5, 5, 'PP-230505', 46000000, 'VND', 'completed', '{"paymentId": "PAY-1AB23456CD789012EF34GHIJ", "payerId": "PAYERID123"}', NULL, 'Phạm Văn Nam', 'phamvn@example.com', '0901234575', '2023-05-05 11:35:42', '2023-05-05 11:20:15'),
(6, 1, 'BT-230506', 2200000, 'VND', 'refunded', '{"bank": "BIDV", "account_number": "9876543210"}', 'Đã hoàn tiền do khách hủy tour', 'Trần Minh Tuấn', 'tranmt@example.com', '0909876543', '2023-05-06 09:15:30', '2023-05-06 08:45:30'),
(7, 3, 'VNP-230507', 9600000, 'VND', 'completed', '{"vnp_TransactionNo": "13350142", "vnp_BankCode": "VNPAY"}', NULL, 'Nguyễn Văn An', 'nguyenvanan@example.com', '0901234567', '2023-05-07 13:25:18', '2023-05-07 13:10:22');

-- -----------------------------------------------------
-- Mock data for transactions
-- -----------------------------------------------------
INSERT INTO `transactions` (`transaction_code`, `payment_id`, `amount`, `currency`, `status`, `payment_method`, `payment_data`, `notes`, `customer_name`, `customer_email`, `customer_phone`, `created_at`) VALUES
('TRX-230501', 1, 4400000, 'VND', 'completed', 'bank_transfer', '{"bank": "Vietcombank", "account_number": "0123456789"}', 'Giao dịch thành công', 'Nguyễn Văn An', 'nguyenvanan@example.com', '0901234567', '2023-05-01 10:30:45'),
('TRX-230502', 2, 6400000, 'VND', 'completed', 'vnpay', '{"vnp_TransactionNo": "13349337", "vnp_BankCode": "NCB"}', 'Giao dịch thành công', 'Lê Văn Cường', 'levc@example.com', '0901234569', '2023-05-02 14:30:22'),
('TRX-230503', 3, 15600000, 'VND', 'completed', 'momo', '{"partnerCode": "MOMO", "orderId": "MM230503", "transId": 2345678}', 'Giao dịch thành công', 'Hoàng Văn Minh', 'hoangvm@example.com', '0901234571', '2023-05-03 09:55:30'),
('TRX-230505', 4, 46000000, 'VND', 'completed', 'paypal', '{"paymentId": "PAY-1AB23456CD789012EF34GHIJ", "payerId": "PAYERID123"}', 'Giao dịch thành công', 'Phạm Văn Nam', 'phamvn@example.com', '0901234575', '2023-05-05 11:35:42'),
('TRX-230506', 5, 2200000, 'VND', 'refunded', 'bank_transfer', '{"bank": "BIDV", "account_number": "9876543210"}', 'Giao dịch đã hoàn tiền', 'Trần Minh Tuấn', 'tranmt@example.com', '0909876543', '2023-05-06 09:15:30'),
('TRX-230507', 6, 9600000, 'VND', 'completed', 'vnpay', '{"vnp_TransactionNo": "13350142", "vnp_BankCode": "VNPAY"}', 'Giao dịch thành công', 'Nguyễn Văn An', 'nguyenvanan@example.com', '0901234567', '2023-05-07 13:25:18');

-- Update payments with transaction_id_internal
UPDATE `payments` SET `transaction_id_internal` = 1 WHERE `id` = 1;
UPDATE `payments` SET `transaction_id_internal` = 2 WHERE `id` = 2;
UPDATE `payments` SET `transaction_id_internal` = 3 WHERE `id` = 3;
UPDATE `payments` SET `transaction_id_internal` = 4 WHERE `id` = 4;
UPDATE `payments` SET `transaction_id_internal` = 5 WHERE `id` = 5;
UPDATE `payments` SET `transaction_id_internal` = 6 WHERE `id` = 6;

-- -----------------------------------------------------
-- Mock data for refunds
-- -----------------------------------------------------
INSERT INTO `refunds` (`refund_code`, `payment_id`, `transaction_id`, `amount`, `currency`, `status`, `reason`, `refund_data`, `notes`, `refunded_by`, `refund_date`, `created_at`) VALUES
('REF-230506', 5, 5, 2200000, 'VND', 'completed', 'Khách hàng hủy tour trước 7 ngày', '{"method": "bank_transfer", "account": "9876543210", "bank": "BIDV"}', 'Hoàn tiền 100% do hủy sớm', 1, '2023-05-08 14:30:00', '2023-05-07 10:15:30');

-- Update payments with refund_id
UPDATE `payments` SET `refund_id` = 1 WHERE `id` = 5;

-- -----------------------------------------------------
-- Mock data for invoices
-- -----------------------------------------------------
INSERT INTO `invoices` (`invoice_number`, `booking_id`, `payment_id`, `user_id`, `amount`, `tax_amount`, `total_amount`, `status`, `issue_date`, `due_date`, `paid_date`, `notes`, `billing_name`, `billing_address`, `billing_email`, `billing_phone`) VALUES
('INV-230501', 1, 1, 1, 4000000, 400000, 4400000, 'paid', '2023-05-01', '2023-05-08', '2023-05-01', NULL, 'Nguyễn Văn An', 'Quận 1, TP.HCM', 'nguyenvanan@example.com', '0901234567'),
('INV-230502', 2, 2, NULL, 5818182, 581818, 6400000, 'paid', '2023-05-02', '2023-05-09', '2023-05-02', NULL, 'Lê Văn Cường', 'Quận 7, TP.HCM', 'levc@example.com', '0901234569'),
('INV-230503', 3, 3, NULL, 14181818, 1418182, 15600000, 'paid', '2023-05-03', '2023-05-10', '2023-05-03', NULL, 'Hoàng Văn Minh', 'Quận Cầu Giấy, Hà Nội', 'hoangvm@example.com', '0901234571'),
('INV-230505', 5, 4, NULL, 41818182, 4181818, 46000000, 'paid', '2023-05-05', '2023-05-12', '2023-05-05', NULL, 'Phạm Văn Nam', 'Quận Đống Đa, Hà Nội', 'phamvn@example.com', '0901234575'),
('INV-230506', 6, 5, NULL, 2000000, 200000, 2200000, 'refunded', '2023-05-06', '2023-05-13', '2023-05-06', 'Đã hoàn tiền', 'Trần Minh Tuấn', 'Quận 3, TP.HCM', 'tranmt@example.com', '0909876543'),
('INV-230507', 7, 6, 1, 8727273, 872727, 9600000, 'paid', '2023-05-07', '2023-05-14', '2023-05-07', NULL, 'Nguyễn Văn An', 'Quận 1, TP.HCM', 'nguyenvanan@example.com', '0901234567'),
('INV-230508', 8, NULL, NULL, 14909091, 1490909, 16400000, 'draft', '2023-05-08', '2023-05-15', NULL, NULL, 'Lê Thị Hương', 'Quận 5, TP.HCM', 'leth@example.com', '0901234580');

-- -----------------------------------------------------
-- Mock data for activity_logs
-- -----------------------------------------------------
INSERT INTO `activity_logs` (`user_id`, `action`, `entity_type`, `entity_id`, `description`, `ip_address`, `created_at`) VALUES
(1, 'create', 'booking', 1, 'Tạo đơn đặt tour mới #BK-230501', '127.0.0.1', '2023-05-01 10:15:30'),
(1, 'create', 'payment', 1, 'Ghi nhận thanh toán cho đơn đặt tour #BK-230501', '127.0.0.1', '2023-05-01 10:30:45'),
(1, 'update', 'booking', 1, 'Cập nhật trạng thái đơn đặt tour #BK-230501 thành "confirmed"', '127.0.0.1', '2023-05-01 10:31:00'),
(1, 'create', 'invoice', 1, 'Tạo hóa đơn #INV-230501 cho đơn đặt tour #BK-230501', '127.0.0.1', '2023-05-01 10:35:15'),
(1, 'create', 'booking', 2, 'Tạo đơn đặt tour mới #BK-230502', '127.0.0.1', '2023-05-02 14:22:45'),
(1, 'create', 'payment', 2, 'Ghi nhận thanh toán cho đơn đặt tour #BK-230502', '127.0.0.1', '2023-05-02 14:30:22'),
(1, 'update', 'booking', 2, 'Cập nhật trạng thái đơn đặt tour #BK-230502 thành "confirmed"', '127.0.0.1', '2023-05-02 14:31:00'),
(1, 'create', 'invoice', 2, 'Tạo hóa đơn #INV-230502 cho đơn đặt tour #BK-230502', '127.0.0.1', '2023-05-02 14:35:15'),
(1, 'create', 'refund', 1, 'Tạo yêu cầu hoàn tiền cho đơn đặt tour #BK-230506', '127.0.0.1', '2023-05-07 10:15:30'),
(1, 'update', 'refund', 1, 'Cập nhật trạng thái hoàn tiền #REF-230506 thành "completed"', '127.0.0.1', '2023-05-08 14:30:00'),
(1, 'update', 'payment', 5, 'Cập nhật trạng thái thanh toán cho đơn đặt tour #BK-230506 thành "refunded"', '127.0.0.1', '2023-05-08 14:31:00'),
(1, 'update', 'invoice', 5, 'Cập nhật trạng thái hóa đơn #INV-230506 thành "refunded"', '127.0.0.1', '2023-05-08 14:32:15');

-- -----------------------------------------------------
-- Mock data for payment_logs
-- -----------------------------------------------------
INSERT INTO `payment_logs` (`payment_id`, `booking_id`, `event`, `status`, `message`, `data`, `ip_address`, `created_at`) VALUES
(1, 1, 'payment_created', 'pending', 'Tạo thanh toán mới', '{"method": "bank_transfer", "amount": 4400000}', '127.0.0.1', '2023-05-01 10:15:30'),
(1, 1, 'payment_completed', 'completed', 'Thanh toán thành công', '{"transaction_code": "TRX-230501"}', '127.0.0.1', '2023-05-01 10:30:45'),
(2, 2, 'payment_created', 'pending', 'Tạo thanh toán mới', '{"method": "vnpay", "amount": 6400000}', '127.0.0.1', '2023-05-02 14:22:45'),
(2, 2, 'payment_completed', 'completed', 'Thanh toán thành công', '{"transaction_code": "TRX-230502"}', '127.0.0.1', '2023-05-02 14:30:22'),
(3, 3, 'payment_created', 'pending', 'Tạo thanh toán mới', '{"method": "momo", "amount": 15600000}', '127.0.0.1', '2023-05-03 09:45:12'),
(3, 3, 'payment_completed', 'completed', 'Thanh toán thành công', '{"transaction_code": "TRX-230503"}', '127.0.0.1', '2023-05-03 09:55:30'),
(5, 6, 'payment_created', 'pending', 'Tạo thanh toán mới', '{"method": "bank_transfer", "amount": 2200000}', '127.0.0.1', '2023-05-06 08:45:30'),
(5, 6, 'payment_completed', 'completed', 'Thanh toán thành công', '{"transaction_code": "TRX-230506"}', '127.0.0.1', '2023-05-06 09:15:30'),
(5, 6, 'refund_requested', 'completed', 'Yêu cầu hoàn tiền', '{"refund_code": "REF-230506", "amount": 2200000}', '127.0.0.1', '2023-05-07 10:15:30'),
(5, 6, 'refund_completed', 'refunded', 'Hoàn tiền thành công', '{"refund_code": "REF-230506", "amount": 2200000}', '127.0.0.1', '2023-05-08 14:30:00');



-- -----------------------------------------------------
-- Mock data for locations (63 Vietnamese provinces/cities)
-- -----------------------------------------------------
INSERT INTO `locations` (`name`, `slug`, `description`, `country`, `region`, `latitude`, `longitude`, `image`, `status`) VALUES
-- Northern Vietnam
('Hà Nội', 'ha-noi', 'Thủ đô Hà Nội, trung tâm chính trị - văn hóa của cả nước với lịch sử nghìn năm văn hiến', 'Việt Nam', 'Miền Bắc', 21.0285, 105.8542, 'locations/ha-noi.jpg', 'active'),
('Hải Phòng', 'hai-phong', 'Thành phố cảng lớn nhất miền Bắc với nhiều bãi biển và đảo đẹp như Đồ Sơn, Cát Bà', 'Việt Nam', 'Miền Bắc', 20.8449, 106.6881, 'locations/hai-phong.jpg', 'active'),
('Quảng Ninh', 'quang-ninh', 'Tỉnh có Vịnh Hạ Long - di sản thiên nhiên thế giới với hàng nghìn đảo đá vôi độc đáo', 'Việt Nam', 'Miền Bắc', 21.0069, 107.2925, 'locations/quang-ninh.jpg', 'active'),
('Bắc Ninh', 'bac-ninh', 'Vùng đất của quan họ - di sản văn hóa phi vật thể của nhân loại với nhiều làng nghề truyền thống', 'Việt Nam', 'Miền Bắc', 21.1214, 106.1151, 'locations/bac-ninh.jpg', 'active'),
('Hải Dương', 'hai-duong', 'Tỉnh với nền văn hóa lâu đời, nổi tiếng với đền Kiếp Bạc, chùa Côn Sơn và nhiều làng nghề truyền thống', 'Việt Nam', 'Miền Bắc', 20.9373, 106.3145, 'locations/hai-duong.jpg', 'active'),
('Hưng Yên', 'hung-yen', 'Vùng đất cổ với nhiều di tích lịch sử, văn hóa và nổi tiếng với đặc sản nhãn lồng', 'Việt Nam', 'Miền Bắc', 20.6464, 106.0511, 'locations/hung-yen.jpg', 'active'),
('Thái Bình', 'thai-binh', 'Tỉnh thuần nông với cánh đồng bằng phì nhiêu và nhiều làng nghề truyền thống', 'Việt Nam', 'Miền Bắc', 20.4462, 106.3366, 'locations/thai-binh.jpg', 'active'),
('Hà Nam', 'ha-nam', 'Tỉnh với nhiều di tích lịch sử, danh thắng nổi tiếng như chùa Tam Chúc, núi Ngọc', 'Việt Nam', 'Miền Bắc', 20.5835, 105.9229, 'locations/ha-nam.jpg', 'active'),
('Nam Định', 'nam-dinh', 'Vùng đất văn hiến với nghề dệt, may truyền thống và nhiều di tích lịch sử - tôn giáo', 'Việt Nam', 'Miền Bắc', 20.4338, 106.1621, 'locations/nam-dinh.jpg', 'active'),
('Ninh Bình', 'ninh-binh', 'Tỉnh có danh thắng Tràng An, Tam Cốc - Bích Động được mệnh danh là "Hạ Long trên cạn"', 'Việt Nam', 'Miền Bắc', 20.2543, 105.9753, 'locations/ninh-binh.jpg', 'active'),
('Vĩnh Phúc', 'vinh-phuc', 'Tỉnh với cảnh quan đẹp như Tam Đảo, đền Hùng và nhiều khu công nghiệp phát triển', 'Việt Nam', 'Miền Bắc', 21.3608, 105.5474, 'locations/vinh-phuc.jpg', 'active'),
('Phú Thọ', 'phu-tho', 'Đất Tổ Hùng Vương với Đền Hùng thiêng liêng và nhiều di tích lịch sử quan trọng', 'Việt Nam', 'Miền Bắc', 21.3227, 105.1249, 'locations/phu-tho.jpg', 'active'),
('Bắc Giang', 'bac-giang', 'Tỉnh nổi tiếng với vải thiều Lục Ngạn và nhiều di tích lịch sử, văn hóa', 'Việt Nam', 'Miền Bắc', 21.2717, 106.1947, 'locations/bac-giang.jpg', 'active'),
('Thái Nguyên', 'thai-nguyen', 'Trung tâm văn hóa, kinh tế vùng trung du và miền núi phía Bắc, nổi tiếng với chè Tân Cương', 'Việt Nam', 'Miền Bắc', 21.5942, 105.8480, 'locations/thai-nguyen.jpg', 'active'),
('Lạng Sơn', 'lang-son', 'Tỉnh biên giới với nhiều cảnh quan đẹp, di tích lịch sử và cửa khẩu thương mại quan trọng', 'Việt Nam', 'Miền Bắc', 21.8564, 106.7615, 'locations/lang-son.jpg', 'active'),
('Cao Bằng', 'cao-bang', 'Tỉnh miền núi biên giới với thác Bản Giốc hùng vĩ và Công viên địa chất toàn cầu UNESCO', 'Việt Nam', 'Miền Bắc', 22.6667, 106.2500, 'locations/cao-bang.jpg', 'active'),
('Bắc Kạn', 'bac-kan', 'Tỉnh miền núi với hồ Ba Bể - hồ nước ngọt tự nhiên lớn nhất Việt Nam', 'Việt Nam', 'Miền Bắc', 22.1477, 105.8347, 'locations/bac-kan.jpg', 'active'),
('Tuyên Quang', 'tuyen-quang', 'Tỉnh với nhiều thắng cảnh đẹp, lễ hội độc đáo và di tích lịch sử cách mạng quan trọng', 'Việt Nam', 'Miền Bắc', 21.7767, 105.2281, 'locations/tuyen-quang.jpg', 'active'),
('Hà Giang', 'ha-giang', 'Tỉnh cực bắc với cao nguyên đá Đồng Văn - công viên địa chất toàn cầu UNESCO và cung đường Hạnh Phúc', 'Việt Nam', 'Miền Bắc', 22.8268, 104.9886, 'locations/ha-giang.jpg', 'active'),
('Yên Bái', 'yen-bai', 'Tỉnh miền núi với ruộng bậc thang Mù Cang Chải tuyệt đẹp và hồ Thác Bà', 'Việt Nam', 'Miền Bắc', 21.7167, 104.9000, 'locations/yen-bai.jpg', 'active'),
('Lào Cai', 'lao-cai', 'Tỉnh biên giới với Sa Pa - thiên đường du lịch và đỉnh Fansipan "nóc nhà Đông Dương"', 'Việt Nam', 'Miền Bắc', 22.4856, 103.9723, 'locations/lao-cai.jpg', 'active'),
('Hòa Bình', 'hoa-binh', 'Tỉnh với hồ Hòa Bình lớn, văn hóa người Mường đặc sắc và nhiều cảnh quan thiên nhiên đẹp', 'Việt Nam', 'Miền Bắc', 20.8133, 105.3383, 'locations/hoa-binh.jpg', 'active'),
('Sơn La', 'son-la', 'Tỉnh miền núi với cảnh quan hùng vĩ, thung lũng Mộc Châu và nhiều bản làng dân tộc thiểu số', 'Việt Nam', 'Miền Bắc', 21.1678, 103.9060, 'locations/son-la.jpg', 'active'),
('Lai Châu', 'lai-chau', 'Tỉnh với địa hình núi cao hiểm trở, cảnh quan thiên nhiên hoang sơ và đẹp như tranh vẽ', 'Việt Nam', 'Miền Bắc', 22.3964, 103.4716, 'locations/lai-chau.jpg', 'active'),
('Điện Biên', 'dien-bien', 'Tỉnh nổi tiếng với chiến thắng Điện Biên Phủ lừng lẫy và văn hóa các dân tộc thiểu số phong phú', 'Việt Nam', 'Miền Bắc', 21.3856, 103.0169, 'locations/dien-bien.jpg', 'active'),

-- Central Vietnam
('Thanh Hóa', 'thanh-hoa', 'Tỉnh với bề dày lịch sử, văn hóa và nhiều danh lam thắng cảnh như Pù Luông, Sầm Sơn', 'Việt Nam', 'Miền Trung', 19.8067, 105.7852, 'locations/thanh-hoa.jpg', 'active'),
('Nghệ An', 'nghe-an', 'Quê hương Chủ tịch Hồ Chí Minh với nhiều di tích lịch sử và bãi biển đẹp như Cửa Lò', 'Việt Nam', 'Miền Trung', 19.2345, 104.9200, 'locations/nghe-an.jpg', 'active'),
('Hà Tĩnh', 'ha-tinh', 'Tỉnh với bề dày lịch sử, văn hóa và nhiều bãi biển hoang sơ, đẹp như Thiên Cầm', 'Việt Nam', 'Miền Trung', 18.3333, 105.9000, 'locations/ha-tinh.jpg', 'active'),
('Quảng Bình', 'quang-binh', 'Tỉnh nổi tiếng với Vườn quốc gia Phong Nha - Kẻ Bàng và hệ thống hang động kỳ vĩ', 'Việt Nam', 'Miền Trung', 17.5000, 106.3333, 'locations/quang-binh.jpg', 'active'),
('Quảng Trị', 'quang-tri', 'Vùng đất lịch sử với nhiều di tích chiến tranh và Vĩ tuyến 17 nổi tiếng', 'Việt Nam', 'Miền Trung', 16.7500, 107.2000, 'locations/quang-tri.jpg', 'active'),
('Thừa Thiên Huế', 'thua-thien-hue', 'Cố đô Huế với quần thể di tích Cố đô Huế được UNESCO công nhận di sản văn hóa thế giới', 'Việt Nam', 'Miền Trung', 16.4633, 107.5856, 'locations/thua-thien-hue.jpg', 'active'),
('Đà Nẵng', 'da-nang', 'Thành phố biển hiện đại, năng động với Bà Nà Hills, bán đảo Sơn Trà và các bãi biển tuyệt đẹp', 'Việt Nam', 'Miền Trung', 16.0544, 108.2022, 'locations/da-nang.jpg', 'active'),
('Quảng Nam', 'quang-nam', 'Tỉnh với hai di sản văn hóa thế giới: phố cổ Hội An và Thánh địa Mỹ Sơn', 'Việt Nam', 'Miền Trung', 15.5394, 108.0191, 'locations/quang-nam.jpg', 'active'),
('Quảng Ngãi', 'quang-ngai', 'Tỉnh với di tích thảm sát Sơn Mỹ, đảo Lý Sơn và nhiều bãi biển hoang sơ', 'Việt Nam', 'Miền Trung', 15.1200, 108.8000, 'locations/quang-ngai.jpg', 'active'),
('Bình Định', 'binh-dinh', 'Tỉnh nổi tiếng với nghệ thuật võ thuật, tháp Chăm cổ và biển Quy Nhơn xanh trong', 'Việt Nam', 'Miền Trung', 13.7756, 109.2239, 'locations/binh-dinh.jpg', 'active'),
('Phú Yên', 'phu-yen', 'Tỉnh với Gành Đá Đĩa độc đáo, bãi biển Đại Lãnh và vịnh Vũng Rô nên thơ', 'Việt Nam', 'Miền Trung', 13.1628, 109.0946, 'locations/phu-yen.jpg', 'active'),
('Khánh Hòa', 'khanh-hoa', 'Tỉnh với vịnh Nha Trang xinh đẹp, Vinpearl Land và nhiều đảo, bãi biển đẹp', 'Việt Nam', 'Miền Trung', 12.2500, 109.1833, 'locations/khanh-hoa.jpg', 'active'),
('Ninh Thuận', 'ninh-thuan', 'Tỉnh với khí hậu khô nhất Việt Nam, vịnh Vĩnh Hy và văn hóa Chăm Pa đặc sắc', 'Việt Nam', 'Miền Trung', 11.6750, 108.8655, 'locations/ninh-thuan.jpg', 'active'),
('Bình Thuận', 'binh-thuan', 'Tỉnh nổi tiếng với Mũi Né, đồi cát bay và nhiều khu nghỉ dưỡng cao cấp', 'Việt Nam', 'Miền Trung', 10.9377, 108.1428, 'locations/binh-thuan.jpg', 'active'),
('Kon Tum', 'kon-tum', 'Tỉnh cao nguyên với nhiều dân tộc thiểu số, nhà rông, nhà sàn và văn hóa đặc sắc', 'Việt Nam', 'Tây Nguyên', 14.3500, 108.0000, 'locations/kon-tum.jpg', 'active'),
('Gia Lai', 'gia-lai', 'Tỉnh với biển hồ T\'Nưng, thác Xung Khoeng và văn hóa cồng chiêng Tây Nguyên', 'Việt Nam', 'Tây Nguyên', 13.9833, 108.0000, 'locations/gia-lai.jpg', 'active'),
('Đắk Lắk', 'dak-lak', 'Tỉnh với voi rừng, hồ Lắk và Festival cà phê Buôn Ma Thuột nổi tiếng', 'Việt Nam', 'Tây Nguyên', 12.7100, 108.2300, 'locations/dak-lak.jpg', 'active'),
('Đắk Nông', 'dak-nong', 'Tỉnh với Công viên địa chất Đắk Nông - UNESCO và thác Đray Sáp hùng vĩ', 'Việt Nam', 'Tây Nguyên', 12.0042, 107.6867, 'locations/dak-nong.jpg', 'active'),
('Lâm Đồng', 'lam-dong', 'Tỉnh với thành phố Đà Lạt mộng mơ, thác Pongour và nhiều đồi chè, rừng thông xanh mát', 'Việt Nam', 'Tây Nguyên', 11.9465, 108.4419, 'locations/lam-dong.jpg', 'active'),

-- Southern Vietnam
('Hồ Chí Minh', 'ho-chi-minh', 'Thành phố năng động nhất, trung tâm kinh tế và văn hóa lớn của cả nước', 'Việt Nam', 'Miền Nam', 10.8231, 106.6297, 'locations/ho-chi-minh.jpg', 'active'),
('Bà Rịa - Vũng Tàu', 'ba-ria-vung-tau', 'Tỉnh với bãi biển Vũng Tàu nổi tiếng, núi Lớn - núi Nhỏ và nhiều khu du lịch nghỉ dưỡng', 'Việt Nam', 'Miền Nam', 10.3553, 107.0843, 'locations/ba-ria-vung-tau.jpg', 'active'),
('Tây Ninh', 'tay-ninh', 'Tỉnh với núi Bà Đen, Tòa Thánh Cao Đài và là cửa khẩu quan trọng với Campuchia', 'Việt Nam', 'Miền Nam', 11.3151, 106.1028, 'locations/tay-ninh.jpg', 'active'),
('Bình Dương', 'binh-duong', 'Tỉnh công nghiệp phát triển nhất miền Nam với nhiều khu công nghiệp hiện đại', 'Việt Nam', 'Miền Nam', 11.1254, 106.6514, 'locations/binh-duong.jpg', 'active'),
('Bình Phước', 'binh-phuoc', 'Tỉnh với nhiều vườn cây ăn trái, vườn quốc gia và thác nước đẹp', 'Việt Nam', 'Miền Nam', 11.7511, 106.7135, 'locations/binh-phuoc.jpg', 'active'),
('Đồng Nai', 'dong-nai', 'Tỉnh với Vườn quốc gia Nam Cát Tiên, hồ Trị An và nhiều khu công nghiệp lớn', 'Việt Nam', 'Miền Nam', 11.0686, 107.1678, 'locations/dong-nai.jpg', 'active'),
('Long An', 'long-an', 'Tỉnh cửa ngõ miền Tây với đồng ruộng bạt ngàn và nhiều vườn trái cây', 'Việt Nam', 'Miền Nam', 10.5600, 106.4126, 'locations/long-an.jpg', 'active'),
('Tiền Giang', 'tien-giang', 'Tỉnh miền Tây với cù lao Thới Sơn, làng cổ Đông Hòa Hiệp và vườn trái cây Cái Bè', 'Việt Nam', 'Miền Nam', 10.4493, 106.3421, 'locations/tien-giang.jpg', 'active'),
('Bến Tre', 'ben-tre', 'Xứ dừa với nhiều kênh rạch, vườn trái cây và làng nghề truyền thống', 'Việt Nam', 'Miền Nam', 10.2433, 106.3756, 'locations/ben-tre.jpg', 'active'),
('Trà Vinh', 'tra-vinh', 'Tỉnh với văn hóa Khmer đặc sắc, nhiều chùa Khmer cổ và vườn trái cây xanh mát', 'Việt Nam', 'Miền Nam', 9.9513, 106.3346, 'locations/tra-vinh.jpg', 'active'),
('Vĩnh Long', 'vinh-long', 'Tỉnh với vườn trái cây, làng nghề truyền thống và homestay miệt vườn nổi tiếng', 'Việt Nam', 'Miền Nam', 10.2531, 105.9722, 'locations/vinh-long.jpg', 'active'),
('Đồng Tháp', 'dong-thap', 'Tỉnh với đồng sen Tháp Mười, làng hoa Sa Đéc và khu di tích Xẻo Quýt', 'Việt Nam', 'Miền Nam', 10.4933, 105.6882, 'locations/dong-thap.jpg', 'active'),
('An Giang', 'an-giang', 'Tỉnh với núi Cấm, núi Sam, khu du lịch Trà Sư và lễ hội đua bò Bảy Núi', 'Việt Nam', 'Miền Nam', 10.5216, 105.1256, 'locations/an-giang.jpg', 'active'),
('Kiên Giang', 'kien-giang', 'Tỉnh với đảo Phú Quốc, Hà Tiên và quần đảo Nam Du tuyệt đẹp', 'Việt Nam', 'Miền Nam', 9.8246, 105.1256, 'locations/kien-giang.jpg', 'active'),
('Cần Thơ', 'can-tho', 'Thành phố lớn nhất miền Tây với chợ nổi Cái Răng, vườn trái cây và ẩm thực phong phú', 'Việt Nam', 'Miền Nam', 10.0452, 105.7469, 'locations/can-tho.jpg', 'active'),
('Hậu Giang', 'hau-giang', 'Tỉnh với cánh đồng lúa mênh mông, vườn trái cây và văn hóa sông nước miền Tây', 'Việt Nam', 'Miền Nam', 9.7579, 105.6413, 'locations/hau-giang.jpg', 'active'),
('Sóc Trăng', 'soc-trang', 'Tỉnh với chùa Dơi, chùa Đất Sét và lễ hội Oóc Om Bóc - đua ghe ngo của người Khmer', 'Việt Nam', 'Miền Nam', 9.6037, 105.9812, 'locations/soc-trang.jpg', 'active'),
('Bạc Liêu', 'bac-lieu', 'Tỉnh với nhà công tử Bạc Liêu, cánh đồng điện gió và khu du lịch Nhà Mát', 'Việt Nam', 'Miền Nam', 9.2940, 105.7216, 'locations/bac-lieu.jpg', 'active'),
('Cà Mau', 'ca-mau', 'Tỉnh cực Nam với cánh đồng cỏ, rừng U Minh, Mũi Cà Mau - điểm cực nam của Tổ quốc và hệ sinh thái rừng ngập mặn độc đáo', 'Việt Nam', 'Miền Nam', 9.1769, 105.1527, 'locations/ca-mau.jpg', 'active');

INSERT INTO `locations` (`name`, `slug`, `description`, `country`, `region`, `latitude`, `longitude`, `image`, `status`) VALUES
('France', 'france', 'Known for the Eiffel Tower, fine cuisine, and art museums like the Louvre.', 'France', 'Europe', 46.603354, 1.888334, '/locations/france', 'active'),
('Japan', 'japan', 'An island nation known for its unique blend of ancient traditions and cutting-edge technology.', 'Japan', 'Asia', 36.204824, 138.252924, '/locations/japan', 'active'),
('Australia', 'australia', 'Famous for its natural wonders, beaches, deserts, and unique wildlife like kangaroos and koalas.', 'Australia', 'Oceania', -25.274398, 133.775136, '/locations/australia', 'active'),
('Brazil', 'brazil', 'Home to the Amazon rainforest, vibrant culture, and famous for its annual Carnival celebration.', 'Brazil', 'South America', -14.235004, -51.92528, '/locations/brazil', 'active'),
('Italy', 'italy', 'Known for its art, architecture, food, and historical landmarks like the Colosseum and Venice canals.', 'Italy', 'Europe', 41.87194, 12.56738, '/locations/italy', 'active'),
('Egypt', 'egypt', 'Famous for ancient monuments like the Great Pyramids of Giza and the Sphinx.', 'Egypt', 'Africa', 26.820553, 30.802498, '/locations/egypt', 'active'),
('United Kingdom', 'united-kingdom', 'Known for its royal family, historical landmarks like Big Ben, and cultural influence.', 'United Kingdom', 'Europe', 55.378051, -3.435973, '/locations/united-kingdom', 'active'),
('Canada', 'canada', 'Famous for its stunning natural landscapes, including the Rocky Mountains and Niagara Falls.', 'Canada', 'North America', 56.130366, -106.346771, '/locations/canada', 'active'),
('Thailand', 'thailand', 'Known for tropical beaches, ornate temples, and vibrant street life.', 'Thailand', 'Asia', 15.870032, 100.992541, '/locations/thailand', 'active'),
('South Africa', 'south-africa', 'Famous for its diverse wildlife, natural landscapes, and cultural diversity.', 'South Africa', 'Africa', -30.559482, 22.937506, '/locations/south-africa', 'active');