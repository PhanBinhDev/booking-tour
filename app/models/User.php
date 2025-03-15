<?php
namespace App\Models;

use PDO;

class User extends BaseModel {
    protected $table = 'users';
    
    /**
     * Xác thực người dùng
     * 
     * @param string $email Email người dùng
     * @param string $password Mật khẩu
     * @return array|false Thông tin người dùng hoặc false nếu xác thực thất bại
     */
    public function authenticate($email, $password) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND status = 'active'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Cập nhật thời gian đăng nhập cuối
            $this->updateLastLogin($user['id']);
            
            // Lấy thông tin quyền
            $user['permissions'] = $this->getUserPermissions($user['role_id']);
            $user['role'] = $this->getUserRole($user['role_id']);
            return $user;
        }
        
        return false;
    }

    /**
     * Lấy thông tin người dùng kèm theo vai trò
     * 
     * @param int $userId ID người dùng
     * @return array Thông tin người dùng kèm vai trò
     */
    public function getUserWithRole($userId) {
        $sql = "SELECT u.*, r.name as role_name, r.id as role_id 
                FROM {$this->table} u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Tìm người dùng theo email
     * 
     * @param string $email Email cần tìm
     * @return array|false Thông tin người dùng hoặc false nếu không tìm thấy
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm người dùng theo email
     * 
     * @param string $email Email cần tìm
     * @return array|false Thông tin người dùng hoặc false nếu không tìm thấy
     */
        public function findById($id) {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
    /**
     * Tìm người dùng theo username
     * 
     * @param string $username Username cần tìm
     * @return array|false Thông tin người dùng hoặc false nếu không tìm thấy
     */
    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Tạo người dùng mới
     * 
     * @param array $data Dữ liệu người dùng
     * @return int|false ID người dùng mới hoặc false nếu thất bại
     */
    public function create($data) {
        try {
            $this->db->beginTransaction();
            
            // Tạo người dùng
            $sql = "INSERT INTO {$this->table} (username, email, password, full_name, phone, role_id, status, email_verified, created_at) 
                    VALUES (:username, :email, :password, :full_name, :phone, :role_id, :status, :email_verified, NOW())";
            
            $stmt = $this->db->prepare($sql);
            
            // Sử dụng bindValue thay vì bindParam cho các phần tử mảng
            $stmt->bindValue(':username', $data['username']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':password', $data['password']);
            $stmt->bindValue(':full_name', $data['full_name'] ?? null);
            $stmt->bindValue(':phone', $data['phone'] ?? null);
            $stmt->bindValue(':role_id', $data['role_id']);
            $stmt->bindValue(':status', $data['status'] ?? 'active');
            $stmt->bindValue(':email_verified', $data['email_verified'] ?? false, PDO::PARAM_BOOL);
            
            $stmt->execute();
            $userId = $this->db->lastInsertId();
            
            // Tạo hồ sơ người dùng
            $sql = "INSERT INTO user_profiles (user_id, created_at) VALUES (:user_id, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId);
            $stmt->execute();
            
            // Ghi log hoạt động
            $this->logActivity($userId, 'user_registered', 'users', $userId, 'User registered');
            
            $this->db->commit();
            return $userId;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Cập nhật thời gian đăng nhập cuối
     * 
     * @param int $userId ID người dùng
     * @return bool Kết quả cập nhật
     */
    private function updateLastLogin($userId) {
        $sql = "UPDATE {$this->table} SET last_login = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }
    
    /**
     * Lấy danh sách quyền của người dùng
     * 
     * @param int $roleId ID vai trò
     * @return array Danh sách quyền
     */
    public function getUserPermissions($roleId) {
        $sql = "SELECT p.name 
                FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                WHERE rp.role_id = :role_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role_id', $roleId);
        $stmt->execute();
        
        $permissions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $permissions[] = $row['name'];
        }
        
        return $permissions;
    }


    /**
     * Kiểm tra xem người dùng có quyền cụ thể hay không
     * 
     * @param int $userId ID của người dùng
     * @param string $permission Tên quyền cần kiểm tra
     * @return bool Trả về true nếu người dùng có quyền, ngược lại trả về false
     */
    public function hasPermission($userId, $permission) {
        // Lấy role_id của người dùng
        $sql = "SELECT u.role_id FROM users u WHERE u.id = :userId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$user) {
            return false;
        }
        
        $roleId = $user['role_id'];
        
        // Kiểm tra xem role có quyền này không
        $sql = "SELECT COUNT(*) FROM role_permissions rp 
                JOIN permissions p ON rp.permission_id = p.id 
                WHERE rp.role_id = :roleId AND p.name = :permission";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':roleId', $roleId, \PDO::PARAM_INT);
        $stmt->bindValue(':permission', $permission, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    public function getUserRole($roleId) {
        $sql = "SELECT * FROM roles WHERE id = :role_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role_id', $roleId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Tạo token xác thực email
     * 
     * @param int $userId ID người dùng
     * @return string|false Token hoặc false nếu thất bại
     */
    public function createVerificationToken($userId) {
        $token = bin2hex(random_bytes(32));
        
        $sql = "UPDATE {$this->table} SET verification_token = :token WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':id', $userId);
        
        if ($stmt->execute()) {
            return $token;
        }
        
        return false;
    }
    
    /**
     * Xác thực email người dùng
     * 
     * @param string $token Token xác thực
     * @return bool Kết quả xác thực
     */
    public function verifyEmail($token) {
        $sql = "UPDATE {$this->table} SET email_verified = true, verification_token = NULL 
                WHERE verification_token = :token";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        
        return $stmt->execute() && $stmt->rowCount() > 0;
    }
    
    /**
     * Tạo token đặt lại mật khẩu
     * 
     * @param string $email Email người dùng
     * @return string|false Token hoặc false nếu thất bại
     */
    public function createPasswordResetToken($email) {
        $user = $this->findByEmail($email);
        
        if (!$user) {
            return false;
        }
        
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $sql = "UPDATE {$this->table} SET reset_token = :token, reset_token_expires = :expires 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires', $expires);
        $stmt->bindParam(':id', $user['id']);
        
        if ($stmt->execute()) {
            return $token;
        }
        
        return false;
    }
    
    /**
     * Đặt lại mật khẩu
     * 
     * @param string $token Token đặt lại mật khẩu
     * @param string $password Mật khẩu mới
     * @return bool Kết quả đặt lại mật khẩu
     */
    public function resetPassword($token, $password) {
        $sql = "SELECT id FROM {$this->table} 
                WHERE reset_token = :token AND reset_token_expires > NOW()";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return false;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "UPDATE {$this->table} 
                SET password = :password, reset_token = NULL, reset_token_expires = NULL 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $user['id']);
        
        return $stmt->execute();
    }
    
    /**
     * Ghi log hoạt động
     * 
     * @param int $userId ID người dùng
     * @param string $action Hành động
     * @param string $entityType Loại đối tượng
     * @param int $entityId ID đối tượng
     * @param string $description Mô tả
     * @return bool Kết quả ghi log
     */
    private function logActivity($userId, $action, $entityType, $entityId, $description) {
        $sql = "INSERT INTO activity_logs (user_id, action, entity_type, entity_id, description, ip_address, user_agent, created_at) 
                VALUES (:user_id, :action, :entity_type, :entity_id, :description, :ip_address, :user_agent, NOW())";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':entity_type', $entityType);
        $stmt->bindParam(':entity_id', $entityId);
        $stmt->bindParam(':description', $description);
        $stmt->bindValue(':ip_address', $_SERVER['REMOTE_ADDR'] ?? null);
        $stmt->bindValue(':user_agent', $_SERVER['HTTP_USER_AGENT'] ?? null);
        
        return $stmt->execute();
    }
}