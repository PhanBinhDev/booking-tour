<?php
namespace App\Models;

class User extends BaseModel {
    protected $table = 'users';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findByUsername($username) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function getUserWithRole($id) {
        $query = "SELECT u.*, r.name as role_name 
                 FROM " . $this->table . " u
                 JOIN roles r ON u.role_id = r.id
                 WHERE u.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function hasPermission($userId, $permissionName) {
        $query = "SELECT COUNT(*) FROM users u
                 JOIN roles r ON u.role_id = r.id
                 JOIN role_permissions rp ON r.id = rp.role_id
                 JOIN permissions p ON rp.permission_id = p.id
                 WHERE u.id = :user_id AND p.name = :permission_name";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':permission_name', $permissionName);
        $stmt->execute();
        
        return (int)$stmt->fetchColumn() > 0;
    }
}