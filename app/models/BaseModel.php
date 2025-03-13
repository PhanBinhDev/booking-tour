<?php
namespace App\Models;

use App\Config\Database;
use PDO;

abstract class BaseModel {
    protected $db;
    protected $table;
    
    public function __construct() {
        global $db;
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Lấy tất cả bản ghi
     * 
     * @param array $conditions Điều kiện lọc
     * @param string $orderBy Sắp xếp theo
     * @param int $limit Giới hạn số bản ghi
     * @param int $offset Vị trí bắt đầu
     * @return array Danh sách bản ghi
     */
    public function getAll($conditions = [], $orderBy = 'id DESC', $limit = null, $offset = null) {
        $sql = "SELECT * FROM {$this->table}";
        
        // Thêm điều kiện WHERE nếu có
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $whereClauses = [];
            
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = :$key";
            }
            
            $sql .= implode(' AND ', $whereClauses);
        }
        
        // Thêm ORDER BY
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
        
        // Thêm LIMIT và OFFSET
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
            
            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $stmt = $this->db->prepare($sql);
        
        // Bind các tham số
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
        
        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            
            if ($offset !== null) {
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy một bản ghi theo ID
     * 
     * @param int $id ID bản ghi
     * @return array|false Thông tin bản ghi hoặc false nếu không tìm thấy
     */
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Cập nhật bản ghi
     * 
     * @param int $id ID bản ghi
     * @param array $data Dữ liệu cập nhật
     * @return bool Kết quả cập nhật
     */
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET ";
        $updateClauses = [];
        
        foreach ($data as $key => $value) {
            $updateClauses[] = "$key = :$key";
        }
        
        $sql .= implode(', ', $updateClauses);
        $sql .= " WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Xóa bản ghi
     * 
     * @param int $id ID bản ghi
     * @return bool Kết quả xóa
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    /**
     * Đếm số bản ghi
     * 
     * @param array $conditions Điều kiện lọc
     * @return int Số bản ghi
     */
    public function count($conditions = []) {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        
        // Thêm điều kiện WHERE nếu có
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $whereClauses = [];
            
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = :$key";
            }
            
            $sql .= implode(' AND ', $whereClauses);
        }
        
        $stmt = $this->db->prepare($sql);
        
        // Bind các tham số
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}