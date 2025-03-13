-- Tạo bảng người dùng
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tạo bảng vai trò
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng quyền hạn
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng liên kết vai trò và quyền hạn
CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

-- Tạo bảng hình ảnh
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    file_name VARCHAR(255) NOT NULL,
    cloudinary_id VARCHAR(255) NOT NULL,
    cloudinary_url VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Chèn các vai trò mặc định
INSERT INTO roles (name, description) VALUES 
('admin', 'Administrator with full access'),
('moderator', 'Moderator with content management permissions'),
('user', 'Regular user with basic permissions');

-- Chèn một số quyền hạn cơ bản
INSERT INTO permissions (name, description) VALUES
('manage_users', 'Can create, edit, delete users'),
('manage_content', 'Can manage all content'),
('upload_images', 'Can upload images'),
('view_dashboard', 'Can view dashboard');

-- Gán quyền cho các vai trò
-- Admin
INSERT INTO role_permissions (role_id, permission_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4);

-- Moderator
INSERT INTO role_permissions (role_id, permission_id) VALUES
(2, 2), (2, 3), (2, 4);

-- User
INSERT INTO role_permissions (role_id, permission_id) VALUES
(3, 3), (3, 4);