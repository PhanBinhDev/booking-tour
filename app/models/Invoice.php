<?php
namespace App\Models;

class Invoice extends BaseModel {
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'invoice_number',
        'transaction_id',
        'user_id',
        'booking_id',
        'amount',
        'tax_amount',
        'total_amount',
        'status',
        'payment_method',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'items',
        'notes',
        'paid_at',
        'created_at',
        'updated_at'
    ];
    
    /**
     * Get paginated invoices
     * 
     * @param int $page Current page
     * @param int $limit Items per page
     * @param array $filters Optional filters
     * @return array Invoices with pagination data
     */
    public function getPaginated($page = 1, $limit = 20, $filters = []) {
        $offset = ($page - 1) * $limit;

        // Build the base query with all necessary joins
        $sql = "SELECT i.*, 
                t.transaction_code,
                b.booking_number,
                COALESCE(i.billing_name, t.customer_name, u.full_name) AS customer_name,
                COALESCE(i.billing_email, t.customer_email, u.email) AS customer_email,
                COALESCE(i.billing_phone, t.customer_phone, u.phone) AS customer_phone,
                pm.name AS payment_method_name
            FROM {$this->table} i
            LEFT JOIN payments p ON i.payment_id = p.id
            LEFT JOIN transactions t ON p.transaction_id_internal = t.id
            LEFT JOIN users u ON i.user_id = u.id
            LEFT JOIN bookings b ON i.booking_id = b.id
            LEFT JOIN payment_methods pm ON p.payment_method_id = pm.id
            WHERE 1=1";
        
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} i WHERE 1=1";
        
        $params = [];
        $countParams = [];
        
        // Apply filters
        if (!empty($filters['search'])) {
            $searchCondition = " AND (i.invoice_number LIKE :search 
                                OR i.billing_name LIKE :search 
                                OR i.billing_email LIKE :search
                                OR u.full_name LIKE :search
                                OR u.email LIKE :search
                                OR b.booking_number LIKE :search)";
            $sql .= $searchCondition;
            $countSql .= $searchCondition;
            $params[':search'] = '%' . $filters['search'] . '%';
            $countParams[':search'] = '%' . $filters['search'] . '%';
        }
        
        // Rest of your existing filter code...
        
        // Add sorting
        $sql .= " ORDER BY i.created_at DESC";
        
        // Add pagination
        $sql .= " LIMIT :limit OFFSET :offset";
        
        // Get total count
        $countStmt = $this->db->prepare($countSql);
        foreach ($countParams as $key => $value) {
            $countStmt->bindValue($key, $value);
        }
        $countStmt->execute();
        $total = $countStmt->fetchColumn();
        
        // Get paginated data
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Calculate pagination metadata
        $totalPages = ceil($total / $limit);
        $hasNextPage = $page < $totalPages;
        $hasPrevPage = $page > 1;
        
        return [
            'data' => $items,
            'pagination' => [
                'total' => $total,
                'per_page' => $limit,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'has_next_page' => $hasNextPage,
                'has_prev_page' => $hasPrevPage,
                'from' => $offset + 1,
                'to' => min($offset + $limit, $total)
            ]
        ];
    }
    
    /**
     * Get invoice by ID with related transaction data
     * 
     * @param int $id Invoice ID
     * @return array|null Invoice data or null if not found
     */
    public function getById($id) {
        $sql = "SELECT i.*, 
                t.transaction_code,
                COALESCE(i.billing_name, t.customer_name, u.full_name) AS customer_name,
                COALESCE(i.billing_email, t.customer_email, u.email) AS customer_email,
                COALESCE(i.billing_phone, t.customer_phone, u.phone) AS customer_phone,
                i.billing_address AS customer_address,
                pm.name AS payment_method_name,
                pm.code AS payment_method_code,
                b.booking_number, b.status AS booking_status
            FROM {$this->table} i
            LEFT JOIN payments p ON i.payment_id = p.id
            LEFT JOIN transactions t ON p.transaction_id_internal = t.id
            LEFT JOIN users u ON i.user_id = u.id
            LEFT JOIN bookings b ON i.booking_id = b.id
            LEFT JOIN payment_methods pm ON p.payment_method_id = pm.id
            WHERE i.id = :id";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get invoice by transaction ID
     * 
     * @param int $transactionId Transaction ID
     * @return array|null Invoice data or null if not found
     */
    public function getByTransactionId($transactionId) {
        $sql = "SELECT i.*, t.transaction_code, t.payment_method as payment_method_name
                FROM {$this->table} i
                INNER JOIN payments p ON i.payment_id = p.id
                LEFT JOIN transactions t ON p.transaction_id_internal = t.id
                WHERE t.id = :transaction_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':transaction_id', $transactionId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Generate invoice from transaction
     * 
     * @param array $transaction Transaction data
     * @return int|bool The ID of the new invoice or false on failure
     */
    public function generateFromTransaction($transaction) {
        // Generate unique invoice number
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . uniqid();
        
        // Calculate tax (example: 10%)
        $taxRate = 0.1;
        $amount = $transaction['amount'];
        $taxAmount = $amount * $taxRate;
        $totalAmount = $amount + $taxAmount;
        
        // Prepare invoice items
        $items = $this->getInvoiceItems($transaction);
        
        // Prepare data
        $data = [
            'invoice_number' => $invoiceNumber,
            'transaction_id' => $transaction['id'],
            'user_id' => $transaction['user_id'] ?? null,
            'booking_id' => $transaction['booking_id'] ?? null,
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'status' => ($transaction['status'] === 'completed') ? 'paid' : 'pending',
            'payment_method' => $transaction['payment_method'],
            'customer_name' => $transaction['customer_name'],
            'customer_email' => $transaction['customer_email'],
            'customer_phone' => $transaction['customer_phone'] ?? null,
            'customer_address' => $transaction['customer_address'] ?? null,
            'items' => json_encode($items),
            'paid_at' => ($transaction['status'] === 'completed') ? date('Y-m-d H:i:s') : null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Create invoice
        $invoiceId = $this->create($data);
        
        if ($invoiceId) {
            // Create invoice attachment if needed
            $this->createInvoiceAttachment($invoiceId);
            return $invoiceId;
        }
        
        return false;
    }
    
    /**
     * Get invoice by invoice number
     * 
     * @param string $invoiceNumber Invoice number
     * @return array|null Invoice data or null if not found
     */
    public function getByInvoiceNumber($invoiceNumber) {
        $sql = "SELECT i.*, t.transaction_code, t.payment_method as payment_method_name
                FROM {$this->table} i
                LEFT JOIN transactions t ON i.transaction_id = t.id
                WHERE i.invoice_number = :invoice_number";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':invoice_number', $invoiceNumber);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get invoices by user ID
     * 
     * @param int $userId User ID
     * @param int $limit Limit number of records
     * @return array List of invoices
     */
    public function getByUserId($userId, $limit = 10) {
        $sql = "SELECT i.*, t.transaction_code, t.payment_method as payment_method_name
                FROM {$this->table} i
                LEFT JOIN transactions t ON i.transaction_id = t.id
                WHERE i.user_id = :user_id
                ORDER BY i.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get invoices by booking ID
     * 
     * @param int $bookingId Booking ID
     * @return array List of invoices
     */
    public function getByBookingId($bookingId) {
        $sql = "SELECT i.*, t.transaction_code, t.payment_method as payment_method_name
                FROM {$this->table} i
                LEFT JOIN transactions t ON i.transaction_id = t.id
                WHERE i.booking_id = :booking_id
                ORDER BY i.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':booking_id', $bookingId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Update invoice status
     * 
     * @param int $id Invoice ID
     * @param string $status New status
     * @return bool True on success, false on failure
     */
    public function updateStatus($id, $status) {
        $data = ['status' => $status];
        
        // If status is changed to paid, update paid_at
        if ($status === 'paid') {
            $data['paid_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->update($id, $data);
    }
    
    /**
     * Create invoice attachment
     * 
     * @param int $invoiceId Invoice ID
     * @return bool True on success, false on failure
     */
    public function createInvoiceAttachment($invoiceId) {
        // Get invoice data
        $invoice = $this->getById($invoiceId);
        if (!$invoice) {
            return false;
        }
        
        // Generate PDF or other attachment
        // This is a placeholder for actual implementation
        // In a real application, you would generate a PDF using a library like TCPDF or Dompdf
        
        // For now, we'll just log that an attachment would be created
        $attachmentPath = 'uploads/invoices/' . $invoice['invoice_number'] . '.pdf';
        
        // Update invoice with attachment path
        return $this->update($invoiceId, [
            'attachment_path' => $attachmentPath,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Get invoice items from transaction
     * 
     * @param array $transaction Transaction data
     * @return array Invoice items
     */
    private function getInvoiceItems($transaction) {
        // This would typically fetch booking details or product details
        if (!empty($transaction['booking_id'])) {
            // Fetch booking details
            $sql = "SELECT b.*, t.name as tour_name 
                    FROM bookings b
                    LEFT JOIN tours t ON b.tour_id = t.id
                    WHERE b.id = :booking_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':booking_id', $transaction['booking_id'], \PDO::PARAM_INT);
            $stmt->execute();
            $booking = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($booking) {
                return [
                    [
                        'name' => 'Tour Booking #' . $booking['booking_number'],
                        'description' => $booking['tour_name'] ?? 'Tour booking',
                        'quantity' => 1,
                        'price' => $transaction['amount'],
                        'total' => $transaction['amount']
                    ]
                ];
            }
        }
        
        // Default item if no booking found
        return [
            [
                'name' => 'Payment',
                'description' => 'Transaction #' . $transaction['transaction_code'],
                'quantity' => 1,
                'price' => $transaction['amount'],
                'total' => $transaction['amount']
            ]
        ];
    }
    
    /**
     * Get invoice statistics
     * 
     * @param string $period Period (daily, weekly, monthly, yearly)
     * @param string $startDate Start date (YYYY-MM-DD)
     * @param string $endDate End date (YYYY-MM-DD)
     * @return array Invoice statistics
     */
    public function getStatistics($period = 'monthly', $startDate = null, $endDate = null) {
        // Set default dates if not provided
        if (!$startDate) {
            $startDate = date('Y-m-d', strtotime('-1 year'));
        }
        
        if (!$endDate) {
            $endDate = date('Y-m-d');
        }
        
        // Format for grouping based on period
        $groupFormat = '';
        switch ($period) {
            case 'daily':
                $groupFormat = '%Y-%m-%d';
                break;
            case 'weekly':
                $groupFormat = '%Y-%u'; // Year and week number
                break;
            case 'monthly':
                $groupFormat = '%Y-%m';
                break;
            case 'yearly':
                $groupFormat = '%Y';
                break;
            default:
                $groupFormat = '%Y-%m';
        }
        
        // Get invoice counts by period
        $sql = "SELECT 
                    DATE_FORMAT(created_at, '{$groupFormat}') as period,
                    COUNT(*) as total_invoices,
                    SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_invoices,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_invoices,
                    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_invoices,
                    SUM(total_amount) as total_amount,
                    SUM(CASE WHEN status = 'paid' THEN total_amount ELSE 0 END) as paid_amount
                FROM {$this->table}
                WHERE created_at BETWEEN :start_date AND :end_date
                GROUP BY period
                ORDER BY period ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':start_date', $startDate . ' 00:00:00');
        $stmt->bindValue(':end_date', $endDate . ' 23:59:59');
        $stmt->execute();
        $periodStats = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Get overall statistics
        $overallSql = "SELECT 
                        COUNT(*) as total_invoices,
                        SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_invoices,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_invoices,
                        SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_invoices,
                        SUM(total_amount) as total_amount,
                        SUM(CASE WHEN status = 'paid' THEN total_amount ELSE 0 END) as paid_amount,
                        AVG(total_amount) as average_invoice_amount
                    FROM {$this->table}
                    WHERE created_at BETWEEN :start_date AND :end_date";
        
        $overallStmt = $this->db->prepare($overallSql);
        $overallStmt->bindValue(':start_date', $startDate . ' 00:00:00');
        $overallStmt->bindValue(':end_date', $endDate . ' 23:59:59');
        $overallStmt->execute();
        $overallStats = $overallStmt->fetch(\PDO::FETCH_ASSOC);
        
        return [
            'period_stats' => $periodStats,
            'overall_stats' => $overallStats
        ];
    }
}