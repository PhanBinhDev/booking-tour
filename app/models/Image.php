<?php
namespace App\Models;

class Image extends BaseModel {
    protected $table = 'images';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getUserImages($userId) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function getAllWithUsers() {
        $query = "SELECT i.*, u.username as username
                 FROM " . $this->table . " i
                 JOIN users u ON i.user_id = u.id
                 ORDER BY i.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}