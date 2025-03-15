<?php
namespace App\Models;

class Transaction extends BaseModel {
    protected $table = 'transactions';
    
    /**
     * Get paginated transactions with additional information
     * 
     * @param int $page Current page
     * @param int $limit Items per page
     * @param array $filters Optional filters
     * @return array Transactions with pagination data
     */
    public function getPaginated($page = 1, $limit = 20, $filters = []) {
        $offset = ($page - 1) * $limit;
        $conditions = '';
        $params = [];
        
        // Build search conditions
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $conditions .= "(transaction_code LIKE :search OR customer_name LIKE :search OR customer_email LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        // Add status filter
        if (!empty($filters['status'])) {
            if (!empty($conditions)) {
                $conditions .= " AND ";
            }
            $conditions .= "status = :status";
            $params['status'] = $filters['status'];
        }

        // Add payment method filter
        if (!empty($filters['payment_method_id'])) {
            if (!empty($conditions)) {
                $conditions .= " AND ";
            }
            $conditions .= "payment_method_id = :payment_method_id";
            $params['payment_method_id'] = $filters['payment_method_id'];
        }
        
        // Add date range filter
        if (!empty($filters['date_from'])) {
            if (!empty($conditions)) {
                $conditions .= " AND ";
            }
            $conditions .= "created_at >= :date_from";
            $params['date_from'] = $filters['date_from'] . ' 00:00:00';
        }
        
        if (!empty($filters['date_to'])) {
            if (!empty($conditions)) {
                $conditions .= " AND ";
            }
            $conditions .= "created_at <= :date_to";
            $params['date_to'] = $filters['date_to'] . ' 23:59:59';
        }
        
        // Get transactions
        $transactions = $this->paginate($offset, $limit, 'created_at', 'DESC', $conditions, $params);
        
        // Get total count for pagination
        $total = $this->count($conditions, $params);
        
        // Enhance transaction data with payment method names
        foreach ($transactions as &$transaction) {
            // Get payment method name
            if (isset($transaction['payment_method_id'])) {
                $transaction['payment_method_name'] = $this->getPaymentMethodName($transaction['payment_method_id']);
            } else {
                $transaction['payment_method_name'] = 'Unknown';
                $transaction['payment_method_id'] = null;
            }
        }
        
        // Build pagination data
        $totalPages = ceil($total / $limit);
        $from = $offset + 1;
        $to = min($offset + $limit, $total);
        
        return [
            'data' => $transactions,
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
     * Create a new transaction
     * 
     * @param array $data Transaction data
     * @return int|bool The ID of the new transaction or false on failure
     */
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (
                    transaction_code, 
                    user_id, 
                    booking_id, 
                    payment_method_id, 
                    amount, 
                    status, 
                    customer_name, 
                    customer_email, 
                    customer_phone, 
                    transaction_data, 
                    created_at
                ) VALUES (
                    :transaction_code, 
                    :user_id, 
                    :booking_id, 
                    :payment_method_id, 
                    :amount, 
                    :status, 
                    :customer_name, 
                    :customer_email, 
                    :customer_phone, 
                    :transaction_data, 
                    NOW()
                )";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':transaction_code', $data['transaction_code']);
        $stmt->bindValue(':user_id', $data['user_id'] ?? null);
        $stmt->bindValue(':booking_id', $data['booking_id'] ?? null);
        $stmt->bindValue(':payment_method_id', $data['payment_method_id']);
        $stmt->bindValue(':amount', $data['amount']);
        $stmt->bindValue(':status', $data['status'] ?? 'pending');
        $stmt->bindValue(':customer_name', $data['customer_name'] ?? '');
        $stmt->bindValue(':customer_email', $data['customer_email'] ?? '');
        $stmt->bindValue(':customer_phone', $data['customer_phone'] ?? '');
        $stmt->bindValue(':transaction_data', json_encode($data['transaction_data'] ?? []));
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update transaction status
     * 
     * @param int $id Transaction ID
     * @param string $status New status
     * @param array $additionalData Additional data to update
     * @return bool Result of the operation
     */
    public function updateStatus($id, $status, $additionalData = []) {
        $data = array_merge(['status' => $status], $additionalData);
        return parent::update($id, $data);
    }
    
    /**
     * Update transaction with all fields
     * 
     * @param int $id Transaction ID
     * @param array $data Transaction data
     * @return bool Result of update
     */
    public function updateTransaction($id, $data) {
        // Use the parent update method from BaseModel
        return parent::update($id, $data);
    }
    
    /**
     * Get payment method name by ID
     * 
     * @param int $paymentMethodId Payment method ID
     * @return string Payment method name
     */
    private function getPaymentMethodName($paymentMethodId) {
        $sql = "SELECT name FROM payment_methods WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $paymentMethodId);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result['name'] : 'Unknown';
    }
    
    /**
     * Get transaction by transaction code
     * 
     * @param string $code Transaction code
     * @return array|false Transaction data or false if not found
     */
    public function getByCode($code) {
        $sql = "SELECT * FROM {$this->table} WHERE transaction_code = :code";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get transactions by user ID
     * 
     * @param int $userId User ID
     * @param int $limit Limit number of records
     * @return array List of transactions
     */
    public function getByUserId($userId, $limit = 10) {
        return parent::getAll(['user_id' => $userId], 'created_at DESC', $limit);
    }
    
    /**
     * Get transactions by booking ID
     * 
     * @param int $bookingId Booking ID
     * @return array List of transactions
     */
    public function getByBookingId($bookingId) {
        return parent::getAll(['booking_id' => $bookingId], 'created_at DESC');
    }

    /**
     * Get all transactions with payment method and customer details
     * 
     * @return array List of all transactions
     */
    public function getAllWithDetails() {
        $sql = "SELECT t.*, pm.name as payment_method, u.name as customer_name, u.email as customer_email 
                FROM {$this->table} t
                LEFT JOIN payment_methods pm ON t.payment_method_id = pm.id
                LEFT JOIN users u ON t.user_id = u.id
                ORDER BY t.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get transaction by ID with related details
     * 
     * @param int $id Transaction ID
     * @return array|false Transaction with details or false if not found
     */
    public function getByIdWithDetails($id) {
        $sql = "SELECT t.*, pm.name as payment_method, pm.code as payment_method_code,
                u.name as customer_name, u.email as customer_email, u.phone as customer_phone
                FROM {$this->table} t
                LEFT JOIN payment_methods pm ON t.payment_method_id = pm.id
                LEFT JOIN users u ON t.user_id = u.id
                WHERE t.id = :id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get transaction details by transaction code
     * 
     * @param string $code Transaction code
     * @return array|false Transaction details or false if not found
     */
    public function getByTransactionCodeWithDetails($code) {
        $sql = "SELECT t.*, pm.name as payment_method, pm.code as payment_method_code,
                u.name as customer_name, u.email as customer_email, u.phone as customer_phone
                FROM {$this->table} t
                LEFT JOIN payment_methods pm ON t.payment_method_id = pm.id
                LEFT JOIN users u ON t.user_id = u.id
                WHERE t.transaction_code = :code";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get transaction statistics
     * 
     * @return array Transaction statistics
     */
    public function getTransactionStats() {
        $sql = "SELECT 
                COUNT(*) as total_count,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed_count,
                SUM(amount) as total_amount,
                SUM(CASE WHEN status = 'completed' THEN amount ELSE 0 END) as completed_amount
                FROM {$this->table}";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}