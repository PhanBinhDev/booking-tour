<?php
namespace App\Models;

use PDO;

class Permission extends BaseModel {
    protected $table = 'permissions';
    
    /**
     * Lấy tất cả quyền được nhóm theo danh mục
     * 
     * @return array Danh sách quyền theo danh mục
     */
    public function getAllGroupedByCategory() {
        $sql = "SELECT * FROM {$this->table} ORDER BY category, name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $grouped = [];
        
        foreach ($permissions as $permission) {
            $category = $permission['category'];
            
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            
            $grouped[$category][] = $permission;
        }
        
        return $grouped;
    }
    
    /**
     * Lấy danh sách quyền của người dùng
     * 
     * @param int $userId ID người dùng
     * @return array Danh sách quyền
     */
    public function getUserPermissions($userId) {
        $sql = "SELECT p.name 
                FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                JOIN users u ON rp.role_id = u.role_id 
                WHERE u.id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Lấy danh sách quyền theo vai trò
     * 
     * @param int $roleId ID vai trò
     * @return array Danh sách quyền
     */
    public function getPermissionsByRole($roleId) {
        $sql = "SELECT p.id 
                FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                WHERE rp.role_id = :role_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role_id', $roleId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}