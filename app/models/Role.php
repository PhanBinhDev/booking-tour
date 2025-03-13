<?php
namespace App\Models;

class Role extends BaseModel {
    protected $table = 'roles';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getRoleWithPermissions($roleId) {
        $query = "SELECT r.*, GROUP_CONCAT(p.name) as permissions
                 FROM " . $this->table . " r
                 LEFT JOIN role_permissions rp ON r.id = rp.role_id
                 LEFT JOIN permissions p ON rp.permission_id = p.id
                 WHERE r.id = :role_id
                 GROUP BY r.id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role_id', $roleId);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function getAllWithPermissionCount() {
        $query = "SELECT r.*, COUNT(rp.permission_id) as permission_count
                 FROM " . $this->table . " r
                 LEFT JOIN role_permissions rp ON r.id = rp.role_id
                 GROUP BY r.id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}