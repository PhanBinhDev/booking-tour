<?php
namespace App\Models;

class Role extends BaseModel {
    protected $table = 'roles';
    
    public function __construct() {
        parent::__construct();
    }
    

    /**
     * Cập nhật quyền cho role
     * 
     * @param int $roleId ID của role
     * @param array $permissionIds Mảng ID của các quyền
     * @return bool Trả về true nếu cập nhật thành công, ngược lại trả về false
     */
    public function updateRolePermissions($roleId, $permissionIds) {
        try {
            $this->db->beginTransaction();
            
            // Xóa tất cả các quyền hiện tại của role
            $sql = "DELETE FROM role_permissions WHERE role_id = :roleId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':roleId', $roleId, \PDO::PARAM_INT);
            $stmt->execute();
            
            // Thêm các quyền mới
            if (!empty($permissionIds)) {
                $values = [];
                $params = [];
                
                foreach ($permissionIds as $i => $permissionId) {
                    $values[] = "(:roleId{$i}, :permissionId{$i})";
                    $params["roleId{$i}"] = $roleId;
                    $params["permissionId{$i}"] = $permissionId;
                }
                
                $sql = "INSERT INTO role_permissions (role_id, permission_id) VALUES " . implode(', ', $values);
                $stmt = $this->db->prepare($sql);
                
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, \PDO::PARAM_INT);
                }
                
                $stmt->execute();
            }
            
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Lấy danh sách quyền của một role
     * 
     * @param int $roleId ID của role
     * @return array Danh sách quyền
     */
    public function getRolePermissions($roleId) {
        $sql = "SELECT p.* FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                WHERE rp.role_id = :roleId 
                ORDER BY p.category, p.name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':roleId', $roleId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy vai trò kèm theo danh sách các quyền
     * 
     * @param int $roleId ID của vai trò
     * @return array Vai trò kèm theo danh sách các quyền
     */

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

    /**
     * Lấy tất cả người dùng kèm theo vai trò
     * 
     * @return array Danh sách người dùng kèm vai trò
     */
    public function getAllWithRoles() {
        $sql = "SELECT u.*, r.name as role_name 
                FROM {$this->table} u 
                LEFT JOIN roles r ON u.role_id = r.id 
                ORDER BY u.id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Lấy tất cả các vai trò kèm theo số lượng quyền
     * 
     * @return array Danh sách vai trò kèm số lượng quyền và số luọng user có quyền tương ứng
     */
    public function getAllWithPermissionCount() {
        $query = "SELECT r.*, 
                COUNT(DISTINCT rp.permission_id) as permission_count,
                COUNT(DISTINCT u.id) as user_count
                FROM " . $this->table . " r
                LEFT JOIN role_permissions rp ON r.id = rp.role_id
                LEFT JOIN users u ON r.id = u.role_id
                GROUP BY r.id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}