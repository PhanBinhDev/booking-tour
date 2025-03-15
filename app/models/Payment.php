<?php
namespace App\Models;

/**
 * Payment Model
 */
class Payment extends BaseModel {
    protected $table = 'payments';
    
    /**
     * Find a payment by ID
     * 
     * @param int $id Payment ID
     * @return array|false Payment data or false if not found
     */
    public function findById($id) {
        return $this->getById($id);
    }
    
    /**
     * Get payment with all related information
     * 
     * @param int $id Payment ID
     * @return array Payment with related data
     */
    public function getWithDetails($id) {
        $sql = "SELECT p.*, 
                pm.name as payment_method_name, pm.code as payment_method_code,
                b.booking_number, b.tour_id,
                t.transaction_code,
                r.refund_code, r.status as refund_status
                FROM {$this->table} p
                LEFT JOIN payment_methods pm ON p.payment_method_id = pm.id
                LEFT JOIN bookings b ON p.booking_id = b.id
                LEFT JOIN transactions t ON p.transaction_id_internal = t.id
                LEFT JOIN refunds r ON p.refund_id = r.id
                WHERE p.id = :id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get payments by booking ID
     * 
     * @param int $bookingId Booking ID
     * @return array Payments for this booking
     */
    public function getByBookingId($bookingId) {
        return $this->getAll(['booking_id' => $bookingId], 'created_at DESC');
    }
    
    /**
     * Create a new payment
     * 
     * @param array $data Payment data
     * @return int|bool New payment ID or false on failure
     */
    public function createPayment($data) {
        // Handle JSON data if needed
        if (isset($data['payment_data']) && is_array($data['payment_data'])) {
            $data['payment_data'] = json_encode($data['payment_data']);
        }
        
        // Set default values
        if (!isset($data['currency'])) {
            $data['currency'] = 'VND';
        }
        
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }
        
        if (!isset($data['payment_date']) && isset($data['status']) && $data['status'] == 'completed') {
            $data['payment_date'] = date('Y-m-d H:i:s');
        }
        
        return $this->create($data);
    }
    
    /**
     * Update payment status
     * 
     * @param int $id Payment ID
     * @param string $status New status
     * @param array $additionalData Additional data to update
     * @return bool Success status
     */
    public function updateStatus($id, $status, $additionalData = []) {
        $data = ['status' => $status];
        
        // If status is completed, set payment date if not already set
        if ($status == 'completed' && !isset($additionalData['payment_date'])) {
            $data['payment_date'] = date('Y-m-d H:i:s');
        }
        
        // Merge additional data
        if (!empty($additionalData)) {
            $data = array_merge($data, $additionalData);
        }
        
        return $this->update($id, $data);
    }
    
    /**
     * Link payment to transaction
     * 
     * @param int $paymentId Payment ID
     * @param int $transactionId Internal transaction ID
     * @param string $externalTransactionId External transaction ID (optional)
     * @return bool Success status
     */
    public function linkTransaction($paymentId, $transactionId, $externalTransactionId = null) {
        $data = ['transaction_id_internal' => $transactionId];
        
        if ($externalTransactionId !== null) {
            $data['transaction_id'] = $externalTransactionId;
        }
        
        return $this->update($paymentId, $data);
    }
    
    /**
     * Link payment to refund
     * 
     * @param int $paymentId Payment ID
     * @param int $refundId Refund ID
     * @return bool Success status
     */
    public function linkRefund($paymentId, $refundId) {
        return $this->update($paymentId, [
            'refund_id' => $refundId,
            'status' => 'refunded'
        ]);
    }
    
    /**
     * Get payments with pagination and filters
     * 
     * @param int $page Current page
     * @param int $limit Items per page
     * @param array $filters Filter options
     * @return array Paginated result with data and pagination info
     */
    public function getPaginated($page = 1, $limit = 10, $filters = []) {
        $offset = ($page - 1) * $limit;
        $conditions = '';
        $params = [];
        
        // Build conditions from filters
        if (!empty($filters)) {
            $whereClauses = [];
            
            if (!empty($filters['search'])) {
                $whereClauses[] = "(transaction_id LIKE :search OR payer_name LIKE :search OR payer_email LIKE :search)";
                $params['search'] = '%' . $filters['search'] . '%';
            }
            
            if (!empty($filters['status'])) {
                $whereClauses[] = "status = :status";
                $params['status'] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $whereClauses[] = "DATE(created_at) >= :date_from";
                $params['date_from'] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $whereClauses[] = "DATE(created_at) <= :date_to";
                $params['date_to'] = $filters['date_to'];
            }
            
            if (!empty($filters['booking_id'])) {
                $whereClauses[] = "booking_id = :booking_id";
                $params['booking_id'] = $filters['booking_id'];
            }
            
            if (!empty($filters['payment_method_id'])) {
                $whereClauses[] = "payment_method_id = :payment_method_id";
                $params['payment_method_id'] = $filters['payment_method_id'];
            }
            
            if (!empty($whereClauses)) {
                $conditions = implode(' AND ', $whereClauses);
            }
        }
        
        // Get paginated data
        $payments = $this->paginate($offset, $limit, 'created_at', 'DESC', $conditions, $params);
        
        // Count total records
        $totalCount = $this->count($conditions, $params);
        
        // Calculate pagination info
        $totalPages = ceil($totalCount / $limit);
        
        // Build pagination data
        $pagination = [
            'current_page' => $page,
            'per_page' => $limit,
            'total_count' => $totalCount,
            'total_pages' => $totalPages,
            'has_previous' => $page > 1,
            'has_next' => $page < $totalPages
        ];
        
        // Return data with pagination info
        return [
            'data' => $payments,
            'pagination' => $pagination
        ];
    }
    
    /**
     * Get payment statistics
     * 
     * @param string $period Period type (daily, monthly, yearly)
     * @param string $startDate Start date (Y-m-d format)
     * @param string $endDate End date (Y-m-d format)
     * @return array Payment statistics
     */
    public function getStatistics($period = 'monthly', $startDate = null, $endDate = null) {
        // Set default dates if not provided
        if (!$startDate) {
            $startDate = date('Y-m-d', strtotime('-1 year'));
        }
        
        if (!$endDate) {
            $endDate = date('Y-m-d');
        }
        
        // Define group format based on period
        $groupFormat = '%Y-%m';  // Default: monthly
        $dateFormat = "DATE_FORMAT(created_at, '%Y-%m')";
        
        if ($period == 'daily') {
            $groupFormat = '%Y-%m-%d';
            $dateFormat = "DATE_FORMAT(created_at, '%Y-%m-%d')";
        } elseif ($period == 'yearly') {
            $groupFormat = '%Y';
            $dateFormat = "DATE_FORMAT(created_at, '%Y')";
        }
        
        // Build SQL
        $sql = "SELECT 
                $dateFormat AS period,
                COUNT(*) AS total_count,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_count,
                SUM(CASE WHEN status = 'refunded' THEN 1 ELSE 0 END) AS refunded_count,
                SUM(CASE WHEN status IN ('pending', 'processing') THEN 1 ELSE 0 END) AS pending_count,
                SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) AS failed_count,
                SUM(CASE WHEN status = 'completed' THEN amount ELSE 0 END) AS total_amount,
                SUM(CASE WHEN status = 'refunded' THEN amount ELSE 0 END) AS refunded_amount
                FROM {$this->table}
                WHERE created_at BETWEEN :start_date AND :end_date
                GROUP BY period
                ORDER BY period ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':start_date', $startDate . ' 00:00:00');
        $stmt->bindParam(':end_date', $endDate . ' 23:59:59');
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create payment log
     * 
     * @param int $paymentId Payment ID
     * @param string $event Event name
     * @param string $status Status
     * @param string $message Message
     * @param array $data Additional data
     * @return bool Success status
     */
    public function logActivity($paymentId, $event, $status, $message = '', $data = []) {
        // If we have a payment_logs table model, we could use it instead
        $sql = "INSERT INTO payment_logs 
                (payment_id, booking_id, event, status, message, data, ip_address) 
                VALUES (:payment_id, :booking_id, :event, :status, :message, :data, :ip_address)";
        
        // Get booking_id from payment
        $payment = $this->getById($paymentId);
        $bookingId = $payment ? $payment['booking_id'] : null;
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':payment_id', $paymentId);
        $stmt->bindParam(':booking_id', $bookingId);
        $stmt->bindParam(':event', $event);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':message', $message);
        
        // Convert data to JSON
        $jsonData = !empty($data) ? json_encode($data) : null;
        $stmt->bindParam(':data', $jsonData);
        
        // Get client IP
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $stmt->bindParam(':ip_address', $ipAddress);
        
        return $stmt->execute();
    }
}