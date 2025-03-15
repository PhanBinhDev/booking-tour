<?php
namespace App\Models;

class ActivityLog extends BaseModel {
    protected $table = 'activity_logs';
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Create a new activity log
     * 
     * @param string $entityType The type of entity (e.g., 'invoice', 'transaction')
     * @param int $entityId The ID of the entity
     * @param string $description Description of the activity
     * @param int|null $userId The ID of the user who performed the action (null for system actions)
     * @return int|bool The ID of the new log entry or false on failure
     */
    public function log($entityType, $entityId, $description, $userId = null) {
        // Get current user ID if not provided
        if ($userId === null && isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }

        $sql = "INSERT INTO {$this->table} (entity_type, entity_id, description, user_id, created_at)
                VALUES (:entity_type, :entity_id, :description, :user_id, NOW())";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':entity_type', $entityType);
        $stmt->bindValue(':entity_id', $entityId);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':user_id', $userId);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Get activity logs for a specific entity
     * 
     * @param string $entityType The type of entity (e.g., 'invoice', 'transaction')
     * @param int $entityId The ID of the entity
     * @param int $limit Maximum number of logs to return
     * @return array Array of activity logs
     */
    public function getByEntityId($entityType, $entityId, $limit = 20) {
        $sql = "SELECT al.*, u.full_name as user_name 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.entity_type = :entity_type AND al.entity_id = :entity_id
                ORDER BY al.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':entity_type', $entityType);
        $stmt->bindValue(':entity_id', $entityId);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get recent activity logs
     * 
     * @param int $limit Maximum number of logs to return
     * @return array Array of activity logs
     */
    public function getRecent($limit = 20) {
        $sql = "SELECT al.*, u.full_name as user_name 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                ORDER BY al.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get activity logs by user
     * 
     * @param int $userId The ID of the user
     * @param int $limit Maximum number of logs to return
     * @return array Array of activity logs
     */
    public function getByUserId($userId, $limit = 20) {
        $sql = "SELECT al.*, u.full_name as user_name 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.user_id = :user_id
                ORDER BY al.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get activity logs by entity type
     * 
     * @param string $entityType The type of entity (e.g., 'invoice', 'transaction')
     * @param int $limit Maximum number of logs to return
     * @return array Array of activity logs
     */
    public function getByEntityType($entityType, $limit = 20) {
        $sql = "SELECT al.*, u.full_name as user_name 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.entity_type = :entity_type
                ORDER BY al.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':entity_type', $entityType);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Search activity logs
     * 
     * @param array $filters Filters to apply to the search
     * @param int $limit Maximum number of logs to return
     * @param int $offset Offset for pagination
     * @return array Array of activity logs
     */
    public function search($filters = [], $limit = 20, $offset = 0) {
        $sql = "SELECT al.*, u.full_name as user_name 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE 1=1";
        
        $params = [];
        
        // Apply filters
        if (!empty($filters['entity_type'])) {
            $sql .= " AND al.entity_type = :entity_type";
            $params[':entity_type'] = $filters['entity_type'];
        }
        
        if (!empty($filters['entity_id'])) {
            $sql .= " AND al.entity_id = :entity_id";
            $params[':entity_id'] = $filters['entity_id'];
        }
        
        if (!empty($filters['user_id'])) {
            $sql .= " AND al.user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND al.description LIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND al.created_at >= :date_from";
            $params[':date_from'] = $filters['date_from'] . ' 00:00:00';
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND al.created_at <= :date_to";
            $params[':date_to'] = $filters['date_to'] . ' 23:59:59';
        }
        
        // Add order and limit
        $sql .= " ORDER BY al.created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        
        // Bind parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Count activity logs based on filters
     * 
     * @param array $filters Filters to apply to the count
     * @return int Number of matching logs
     */
    public function countByFilters($filters = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        
        $params = [];
        
        // Apply filters
        if (!empty($filters['entity_type'])) {
            $sql .= " AND entity_type = :entity_type";
            $params[':entity_type'] = $filters['entity_type'];
        }
        
        if (!empty($filters['entity_id'])) {
            $sql .= " AND entity_id = :entity_id";
            $params[':entity_id'] = $filters['entity_id'];
        }
        
        if (!empty($filters['user_id'])) {
            $sql .= " AND user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND description LIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND created_at >= :date_from";
            $params[':date_from'] = $filters['date_from'] . ' 00:00:00';
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND created_at <= :date_to";
            $params[':date_to'] = $filters['date_to'] . ' 23:59:59';
        }
        
        $stmt = $this->db->prepare($sql);
        
        // Bind parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result['total'] : 0;
    }

    /**
     * Delete old activity logs
     * 
     * @param int $days Number of days to keep logs for
     * @return bool True on success, false on failure
     */
    public function deleteOldLogs($days = 90) {
        $date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        $sql = "DELETE FROM {$this->table} WHERE created_at < :date";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':date', $date);
        
        return $stmt->execute();
    }
    
    /**
     * Get paginated activity logs with user information
     *
     * @param int $page Current page
     * @param int $limit Items per page
     * @param array $filters Optional filters
     * @return array Activity logs with pagination data
     */
    public function getPaginated($page = 1, $limit = 20, $filters = []) {
        $offset = ($page - 1) * $limit;
        
        // Get logs
        $logs = $this->search($filters, $limit, $offset);
        
        // Get total count for pagination
        $total = $this->countByFilters($filters);
        
        // Build pagination data
        $totalPages = ceil($total / $limit);
        $from = $offset + 1;
        $to = min($offset + $limit, $total);
        
        return [
            'data' => $logs,
            'pagination' => [
                'total' => $total,
                'per_page' => $limit,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'from' => $from,
                'to' => $to
            ]
        ];
    }
}