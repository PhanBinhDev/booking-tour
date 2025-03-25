<?php
namespace App\Models;

class Refund extends BaseModel {
    protected $table = 'refunds';
    
    /**
     * Get paginated refunds
     * 
     * @param int $page Current page
     * @param int $limit Items per page
     * @param array $filters Optional filters
     * @return array Refunds with pagination data
     */
    public function getPaginated($page = 1, $limit = 20, $filters = []) {
        $offset = ($page - 1) * $limit;
        $conditions = '';
        $params = [];
        
        // Build search conditions
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $conditions .= "(r.refund_code LIKE :search OR t.customer_name LIKE :search OR t.customer_email LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        // Add status filter - FIXED: Added table alias 'r.'
        if (!empty($filters['status'])) {
            if (!empty($conditions)) {
                $conditions .= " AND ";
            }
            $conditions .= "r.status = :status";  // Added 'r.' to specify the table
            $params['status'] = $filters['status'];
        }
        
        // Add date range filter - FIXED: Added table alias 'r.'
        if (!empty($filters['date_from'])) {
            if (!empty($conditions)) {
                $conditions .= " AND ";
            }
            $conditions .= "r.created_at >= :date_from";  // Added 'r.' to specify the table
            $params['date_from'] = $filters['date_from'] . ' 00:00:00';
        }
        
        if (!empty($filters['date_to'])) {
            if (!empty($conditions)) {
                $conditions .= " AND ";
            }
            $conditions .= "r.created_at <= :date_to";  // Added 'r.' to specify the table
            $params['date_to'] = $filters['date_to'] . ' 23:59:59';
        }
        
        // Get refunds with transaction information
        $sql = "SELECT r.*, t.transaction_code, t.customer_name, t.customer_email, t.customer_phone 
                FROM {$this->table} r
                LEFT JOIN transactions t ON r.transaction_id = t.id";
        
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }
        
        $sql .= " ORDER BY r.created_at DESC LIMIT :offset, :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
        
        $stmt->execute();
        $refunds = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Get total count for pagination - FIXED: Updated count query to use same conditions
        $countSql = "SELECT COUNT(*) FROM {$this->table} r";
        
        // Add joins if needed for accurate counting with conditions
        if (strpos($conditions, 't.') !== false) {
            $countSql .= " LEFT JOIN transactions t ON r.transaction_id = t.id";
        }
        
        if (!empty($conditions)) {
            $countSql .= " WHERE $conditions";
        }
        
        $countStmt = $this->db->prepare($countSql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $countStmt->bindValue(":$key", $value);
            }
        }
        
        $countStmt->execute();
        $total = $countStmt->fetchColumn();
        
        // Build pagination data
        $totalPages = ceil($total / $limit);
        $from = $offset + 1;
        $to = min($offset + $limit, $total);
        
        return [
            'data' => $refunds,
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
    
    /**
     * Process a refund request
     * 
     * @param array $data Refund data
     * @return int|bool The ID of the new refund or false on failure
     */
    public function process($data) {
        // Generate unique refund code
        $refundCode = 'REF-' . date('Ymd') . '-' . uniqid();
        
        $sql = "INSERT INTO {$this->table} (
                    refund_code, 
                    transaction_id, 
                    booking_id, 
                    amount, 
                    reason, 
                    status, 
                    refund_data, 
                    created_at
                ) VALUES (
                    :refund_code, 
                    :transaction_id, 
                    :booking_id, 
                    :amount, 
                    :reason, 
                    :status, 
                    :refund_data, 
                    NOW()
                )";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':refund_code', $refundCode);
        $stmt->bindValue(':transaction_id', $data['transaction_id']);
        $stmt->bindValue(':booking_id', $data['booking_id'] ?? null);
        $stmt->bindValue(':amount', $data['amount']);
        $stmt->bindValue(':reason', $data['reason'] ?? '');
        $stmt->bindValue(':status', $data['status'] ?? 'pending');
        $stmt->bindValue(':refund_data', json_encode($data['refund_data'] ?? []));
        
        if ($stmt->execute()) {
            $refundId = $this->db->lastInsertId();
            
            // Update transaction status if needed
            if (!empty($data['update_transaction']) && $data['update_transaction'] === true) {
                $transactionModel = new Transaction();
                $transactionModel->updateStatus($data['transaction_id'], 'refunded', [
                    'refund_id' => $refundId,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            
            return $refundId;
        }
        
        return false;
    }
    
    /**
     * Update refund status
     * 
     * @param int $id Refund ID
     * @param string $status New status
     * @param array $additionalData Additional data to update
     * @return bool Result of the operation
     */
    public function updateStatus($id, $status, $additionalData = []) {
        $data = array_merge(['status' => $status], $additionalData);
        return $this->update($id, $data);
    }
    
    /**
     * Get refund by refund code
     * 
     * @param string $refundCode Refund code
     * @return array|false Refund data or false if not found
     */
    public function getByRefundCode($refundCode) {
        $sql = "SELECT * FROM {$this->table} WHERE refund_code = :refund_code";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':refund_code', $refundCode);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get refunds by transaction ID
     * 
     * @param int $transactionId Transaction ID
     * @return array List of refunds
     */
    public function getByTransactionId($transactionId) {
        return $this->getAll("*",['transaction_id' => $transactionId], 'created_at DESC');
    }
    
    /**
     * Get refunds by booking ID
     * 
     * @param int $bookingId Booking ID
     * @return array List of refunds
     */
    public function getByBookingId($bookingId) {
        return $this->getAll("*",['booking_id' => $bookingId], 'created_at DESC');
    }

    public function getById($id) {
    $sql = "SELECT r.*,
            p.booking_id, p.payment_method_id, p.transaction_id AS external_transaction_id,
            t.transaction_code, t.amount AS transaction_amount,
            pm.name AS payment_method_name, pm.code AS payment_method_code,
            COALESCE(JSON_UNQUOTE(JSON_EXTRACT(r.refund_data, '$.customer_name')), t.customer_name, u.full_name, p.payer_name) AS customer_name,
            COALESCE(JSON_UNQUOTE(JSON_EXTRACT(r.refund_data, '$.customer_email')), t.customer_email, u.email, p.payer_email) AS customer_email,
            COALESCE(JSON_UNQUOTE(JSON_EXTRACT(r.refund_data, '$.customer_phone')), t.customer_phone, u.phone, p.payer_phone) AS customer_phone,
            b.booking_number,
            u2.full_name AS refunded_by_name
        FROM {$this->table} r
        LEFT JOIN payments p ON r.payment_id = p.id
        LEFT JOIN transactions t ON r.transaction_id = t.id
        LEFT JOIN bookings b ON p.booking_id = b.id
        LEFT JOIN payment_methods pm ON p.payment_method_id = pm.id
        LEFT JOIN users u ON b.user_id = u.id
        LEFT JOIN users u2 ON r.refunded_by = u2.id
        WHERE r.id = :id";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
}