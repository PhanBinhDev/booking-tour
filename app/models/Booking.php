<?php


namespace App\Models;

use PDO;

class Booking extends BaseModel
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'booking_number',
        'user_id',
        'tour_id',
        'departure_date',
        'return_date',
        'number_of_people',
        'adults',
        'children',
        'infants',
        'total_price',
        'discount_amount',
        'final_price',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'special_requests',
        'status',
        'payment_status',
        'created_at',
        'updated_at'
    ];


    /**
     * Count bookings by status
     *
     * This function retrieves the count of bookings with a specific status.
     *
     * @param string $status The status to count bookings for
     *
     * @return int The number of bookings with the specified status
     */
    public function countByStatus($status)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = :status";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'];
    }


    /**
     * Get booking by ID
     * 
     * @param int $id Booking ID
     * @return array|null Booking data or null if not found
     */
    public function getById($id)
    {
        $sql = "SELECT b.*, 
                t.title as tour_name, 
                t.slug as tour_slug,
                t.duration,
                t.price as tour_price,
                t.sale_price as tour_sale_price,
                tc.name as tour_category,
                l.name as tour_location,
                dl.name as departure_location,
                (SELECT img.file_path FROM tour_images ti 
                JOIN images img ON ti.image_id = img.id 
                WHERE ti.tour_id = t.id AND ti.is_featured = 1 
                LIMIT 1) as tour_image
            FROM {$this->table} b
            LEFT JOIN tours t ON b.tour_id = t.id
            LEFT JOIN tour_categories tc ON t.category_id = tc.id
            LEFT JOIN locations l ON t.location_id = l.id
            LEFT JOIN locations dl ON t.departure_location_id = dl.id
            WHERE b.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get booking by booking number
     * 
     * @param string $bookingNumber Booking number
     * @return array|null Booking data or null if not found
     */
    public function getByBookingNumber($bookingNumber)
    {
        $sql = "SELECT b.*, t.name as tour_name, t.destination, t.duration
                FROM {$this->table} b
                LEFT JOIN tours t ON b.tour_id = t.id
                WHERE b.booking_number = :booking_number";


        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':booking_number', $bookingNumber);
        $stmt->execute();


        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get bookings by user ID
     * 
     * @param int $userId User ID
     * @return array Array of bookings
     */
    public function getByUserId($userId)
    {
        $sql = "SELECT b.*, t.name as tour_name, t.destination, t.duration
                FROM {$this->table} b
                LEFT JOIN tours t ON b.tour_id = t.id
                WHERE b.user_id = :user_id
                ORDER BY b.created_at DESC";


        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();


        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get bookings by tour ID
     * 
     * @param int $tourId Tour ID
     * @return array Array of bookings
     */
    public function getByTourId($tourId)
    {
        $sql = "SELECT b.*, t.name as tour_name, t.destination, t.duration
                FROM {$this->table} b
                LEFT JOIN tours t ON b.tour_id = t.id
                WHERE b.tour_id = :tour_id
                ORDER BY b.departure_date ASC";


        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tour_id', $tourId, \PDO::PARAM_INT);
        $stmt->execute();


        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get paginated bookings with optional filters
     * 
     * @param int $page Page number
     * @param int $limit Items per page
     * @param array $filters Optional filters
     * @return array Paginated bookings with pagination metadata
     */
    public function getPaginated($page = 1, $limit = 10, $filters = [])
    {
        $offset = ($page - 1) * $limit;

        // Build the base query
        $sql = "SELECT b.*, t.title as tour_title, t.duration, u.full_name as customer_name, 
                u.id as customer_id, b.total_price as tour_price, b.status as booking_status, 
                b.created_at as booking_date, b.payment_status
                FROM {$this->table} b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN tour_dates td ON b.tour_date_id = td.id
                LEFT JOIN users u ON b.user_id = u.id
                WHERE 1=1";

        $countSql = "SELECT COUNT(*) as total FROM {$this->table} b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN users u ON b.user_id = u.id
                WHERE 1=1";

        $params = [];
        $countParams = [];

        // Apply filter for status
        if (!empty($filters['status'])) {
            $sql .= " AND b.status = :status";
            $countSql .= " AND b.status = :status";
            $params[':status'] = $filters['status'];
            $countParams[':status'] = $filters['status'];
        }

        // Apply filter for payment_status
        if (!empty($filters['payment_status'])) {
            $sql .= " AND b.payment_status = :payment_status";
            $countSql .= " AND b.payment_status = :payment_status";
            $params[':payment_status'] = $filters['payment_status'];
            $countParams[':payment_status'] = $filters['payment_status'];
        }

        // Apply filter for tour_category - ĐÂY LÀ PHẦN CẦN THÊM MỚI
        if (!empty($filters['tour_category'])) {
            $sql .= " AND t.category_id = :tour_category";
            $countSql .= " AND t.category_id = :tour_category";
            $params[':tour_category'] = $filters['tour_category'];
            $countParams[':tour_category'] = $filters['tour_category'];
        }

        // Apply other filters (keep existing code)...

        // Add sorting and pagination
        $sql .= " ORDER BY b.created_at DESC";
        $sql .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;


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
            $paramType = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $paramType);
        }
        $stmt->execute();
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        // Calculate pagination metadata
        $totalPages = ceil($total / $limit);
        $hasNextPage = $page < $totalPages;
        $hasPrevPage = $page > 1;

        // Calculate from and to values for displaying "Showing X to Y of Z results"
        $from = $total > 0 ? ($page - 1) * $limit + 1 : 0;
        $to = min($page * $limit, $total);

        return [
            'items' => $items,
            'pagination' => [
                'total' => $total,
                'per_page' => $limit,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'has_next_page' => $hasNextPage,
                'has_prev_page' => $hasPrevPage,
                'from' => $from,
                'to' => $to
            ]
        ];
    }

    /**
     * Count bookings by status and year
     * 
     * @param string $status Status to count
     * @param int $year Year to filter by
     * @return int Count of bookings
     */
    public function countByStatusAndYear($status, $year)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
            WHERE status = :status AND YEAR(created_at) = :year";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':year', $year, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'];
    }

    /**
     * Update booking status
     * 
     * @param int $id Booking ID
     * @param string $status New status
     * @return bool True on success, false on failure
     */
    public function updateStatus($id, $status)
    {
        $allowedStatuses = ['pending', 'confirmed', 'paid', 'cancelled', 'completed'];

        if (!in_array($status, $allowedStatuses)) {
            throw new \InvalidArgumentException("Trạng thái không hợp lệ.");
        }
        return $this->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Update payment status
     * 
     * @param int $id Booking ID
     * @param string $paymentStatus New payment status
     * @return bool True on success, false on failure
     */
    public function updatePaymentStatus($id, $paymentStatus)
    {
        return $this->update($id, [
            'payment_status' => $paymentStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Generate a unique booking number
     * 
     * @return string Unique booking number
     */
    public function generateBookingNumber()
    {
        $prefix = 'BK';
        $date = date('Ymd');
        $random = strtoupper(substr(uniqid(), -4));


        return $prefix . $date . $random;
    }

    /**
     * Get booking statistics
     * 
     * @param string $period Period (daily, weekly, monthly, yearly)
     * @param string $startDate Start date (YYYY-MM-DD)
     * @param string $endDate End date (YYYY-MM-DD)
     * @return array Booking statistics
     */
    public function getStatistics($period = 'monthly', $startDate = null, $endDate = null)
    {
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


        // Get booking counts by period
        $sql = "SELECT 
                    DATE_FORMAT(created_at, '{$groupFormat}') as period,
                    COUNT(*) as total_bookings,
                    SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed_bookings,
                    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_bookings,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_bookings,
                    SUM(final_price) as total_revenue
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
                        COUNT(*) as total_bookings,
                        SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed_bookings,
                        SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_bookings,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_bookings,
                        SUM(final_price) as total_revenue,
                        AVG(final_price) as average_booking_value,
                        AVG(number_of_people) as average_group_size
                    FROM {$this->table}
                    WHERE created_at BETWEEN :start_date AND :end_date";


        $overallStmt = $this->db->prepare($overallSql);
        $overallStmt->bindValue(':start_date', $startDate . ' 00:00:00');
        $overallStmt->bindValue(':end_date', $endDate . ' 23:59:59');
        $overallStmt->execute();
        $overallStats = $overallStmt->fetch(\PDO::FETCH_ASSOC);


        // Get top tours
        $topToursSql = "SELECT 
                            b.tour_id,
                            t.name as tour_name,
                            COUNT(*) as booking_count,
                            SUM(b.final_price) as total_revenue
                        FROM {$this->table} b
                        JOIN tours t ON b.tour_id = t.id
                        WHERE b.created_at BETWEEN :start_date AND :end_date
                        GROUP BY b.tour_id, t.name
                        ORDER BY booking_count DESC
                        LIMIT 5";


        $topToursStmt = $this->db->prepare($topToursSql);
        $topToursStmt->bindValue(':start_date', $startDate . ' 00:00:00');
        $topToursStmt->bindValue(':end_date', $endDate . ' 23:59:59');
        $topToursStmt->execute();
        $topTours = $topToursStmt->fetchAll(\PDO::FETCH_ASSOC);


        return [
            'period_stats' => $periodStats,
            'overall_stats' => $overallStats,
            'top_tours' => $topTours
        ];
    }


    // 
    /**
     * Get recent bookings.
     * 
     * Fetches the most recent bookings based on the created_at column in descending order.
     * 
     * @param int $limit The maximum number of bookings to retrieve. Default is 5.
     * 
     * @return array An array of recent bookings, each represented as an associative array.
     * 
     * Each booking array will contain the following keys:
     * - id: The booking ID.
     * - booking_number: The booking number.
     * - status: The booking status.
     * - created_at: The date and time when the booking was created.
     * - tour_title: The title of the tour associated with the booking.
     * - customer_name: The name of the customer associated with the booking.
     */
    public function getRecent($limit = 5)
    {
        $sql = "
            SELECT DISTINCT
                b.id, 
                b.booking_number, 
                b.status, 
                b.created_at,
                t.title as tour_title,
                COALESCE(u.full_name, bc.full_name) as customer_name
            FROM 
                {$this->table} b
            LEFT JOIN 
                tours t ON b.tour_id = t.id
            LEFT JOIN 
                users u ON b.user_id = u.id
            LEFT JOIN 
                (SELECT booking_id, MIN(full_name) as full_name, MIN(id) as min_id
                FROM booking_customers 
                WHERE type = 'adult' 
                GROUP BY booking_id) bc ON bc.booking_id = b.id
            ORDER BY 
                b.created_at DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Get booking statistics.
     *
     * This function retrieves various statistics about bookings, including total bookings,
     * counts of bookings in different statuses, and total revenue.
     *
     * @return array An associative array containing the following statistics:
     *               - total_bookings: The total number of bookings.
     *               - pending_bookings: The number of bookings with 'pending' status.
     *               - confirmed_bookings: The number of bookings with 'confirmed' status.
     *               - paid_bookings: The number of bookings with 'paid' status.
     *               - cancelled_bookings: The number of bookings with 'cancelled' status.
     *               - completed_bookings: The number of bookings with 'completed' status.
     *               - total_revenue: The sum of total_price for all bookings.
     */
    public function getBookingStatistics()
    {
        $sql = "
            SELECT 
                COUNT(*) as total_bookings,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_bookings,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed_bookings,
                SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_bookings,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_bookings,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_bookings,
                SUM(total_price) as total_revenue
            FROM 
                {$this->table}
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllBookings()
    {
        $sql = "SELECT 
                    b.*,
                    b.booking_number, 
                    b.status AS booking_status, 
                    b.created_at AS booking_date,
                    b.adults, b.children,
                    t.title AS tour_title, 
                    t.price AS tour_price,
                    t.duration,
                    bc.full_name AS customer_name,
                    bc.id AS customer_id,
                    pl.status AS payment_status
                FROM {$this->table} b
                INNER JOIN tours t ON b.tour_id = t.id
                LEFT JOIN (
                    SELECT booking_id, MIN(id) as id, MIN(full_name) as full_name
                    FROM booking_customers 
                    WHERE type = 'adult'
                    GROUP BY booking_id
                ) bc ON b.id = bc.booking_id
                LEFT JOIN (
                    SELECT booking_id, status
                    FROM payment_logs
                    WHERE id IN (
                        SELECT MAX(id) 
                        FROM payment_logs 
                        GROUP BY booking_id
                    )
                ) pl ON b.id = pl.booking_id
                ORDER BY b.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get detailed booking information for single booking view
     * 
     * @param int $id Booking ID
     * @return array|false Combined booking details or false if not found
     */
    public function getBookingDetails($id)
    {
        // 1. Get main booking information with user details
        $sql = "SELECT b.*,
                b.status AS booking_status,
                b.payment_status,
                b.created_at AS booking_date,
                b.tour_id,
                u.id AS customer_id,
                u.full_name AS customer_name,
                u.email AS customer_email,
                u.phone AS customer_phone,
                u.address AS customer_address,
                u.avatar AS customer_avatar
            FROM {$this->table} b
            LEFT JOIN users u ON b.user_id = u.id
            WHERE b.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $booking = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$booking) {
            return false;
        }

        // 2. Get tour information with category
        $tourSql = "SELECT t.*,
                    tc.id AS category_id,
                    tc.name AS category_name,
                    tc.slug AS category_slug,
                    l.name AS destination,
                    dl.name AS departure_location,
                    i.file_path AS thumbnail
                FROM tours t
                LEFT JOIN tour_categories tc ON t.category_id = tc.id
                LEFT JOIN locations l ON t.location_id = l.id
                LEFT JOIN locations dl ON t.departure_location_id = dl.id
                LEFT JOIN tour_images ti ON t.id = ti.tour_id AND ti.is_featured = 1
                LEFT JOIN images i ON ti.image_id = i.id
                WHERE t.id = :tour_id";

        $tourStmt = $this->db->prepare($tourSql);
        $tourStmt->bindParam(':tour_id', $booking['tour_id'], \PDO::PARAM_INT);
        $tourStmt->execute();
        $tour = $tourStmt->fetch(\PDO::FETCH_ASSOC);

        // 3. Get tour date information if available
        if (!empty($booking['tour_date_id'])) {
            $dateSql = "SELECT * FROM tour_dates WHERE id = :date_id";
            $dateStmt = $this->db->prepare($dateSql);
            $dateStmt->bindParam(':date_id', $booking['tour_date_id'], \PDO::PARAM_INT);
            $dateStmt->execute();
            $tourDate = $dateStmt->fetch(\PDO::FETCH_ASSOC);
            $booking['tour_start_date'] = $tourDate['start_date'] ?? null;
            $booking['tour_end_date'] = $tourDate['end_date'] ?? null;
        }

        // 4. Get payment information
        $paymentSql = "SELECT p.*,
                        p.amount,
                        p.status AS payment_status,
                        p.transaction_id,
                        p.created_at AS payment_date,
                        pm.name AS payment_method_name,
                        pm.code AS payment_method_code
                    FROM payments p
                    LEFT JOIN payment_methods pm ON p.payment_method_id = pm.id
                    WHERE p.booking_id = :booking_id
                    ORDER BY p.created_at DESC";

        $paymentStmt = $this->db->prepare($paymentSql);
        $paymentStmt->bindParam(':booking_id', $id, \PDO::PARAM_INT);
        $paymentStmt->execute();
        $payments = $paymentStmt->fetchAll(\PDO::FETCH_ASSOC);
        $payment = !empty($payments) ? $payments[0] : null;

        // 5. Get payment logs for history
        $logsSql = "SELECT pl.*,
                    pl.event,
                    pl.status,
                    pl.message,
                    pl.created_at
                FROM payment_logs pl
                WHERE pl.booking_id = :booking_id
                ORDER BY pl.created_at DESC";

        $logsStmt = $this->db->prepare($logsSql);
        $logsStmt->bindParam(':booking_id', $id, \PDO::PARAM_INT);
        $logsStmt->execute();
        $paymentLogs = $logsStmt->fetchAll(\PDO::FETCH_ASSOC);

        // 6. Get activity logs related to this booking
        $activitySql = "SELECT al.*,
                    al.action,
                    al.description,
                    al.created_at,
                    u.full_name AS admin_name
                FROM activity_logs al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.entity_type = 'booking' AND al.entity_id = :booking_id
                ORDER BY al.created_at DESC";

        $activityStmt = $this->db->prepare($activitySql);
        $activityStmt->bindParam(':booking_id', $id, \PDO::PARAM_INT);
        $activityStmt->execute();
        $activityLogs = $activityStmt->fetchAll(\PDO::FETCH_ASSOC);

        // 7. Combine payment logs and activity logs to create booking history
        $bookingHistory = [];

        // Add payment logs to history
        foreach ($paymentLogs as $log) {
            $status = '';
            $description = $log['message'] ?? '';

            if (strpos($log['event'], 'payment_completed') !== false) {
                $status = 'paid';
            } elseif (strpos($log['event'], 'refund_completed') !== false) {
                $status = 'refunded';
            } elseif (strpos($log['event'], 'payment_created') !== false) {
                $status = 'pending';
            } elseif (strpos($log['event'], 'payment_failed') !== false) {
                $status = 'failed';
            }

            $bookingHistory[] = [
                'status' => $status,
                'description' => $description,
                'created_at' => $log['created_at'],
                'admin_name' => null,
                'type' => 'payment'
            ];
        }

        // Add activity logs to history
        foreach ($activityLogs as $log) {
            $status = '';
            if (strpos($log['action'], 'update') !== false && strpos($log['description'], 'confirmed') !== false) {
                $status = 'confirmed';
            } elseif (strpos($log['action'], 'update') !== false && strpos($log['description'], 'cancelled') !== false) {
                $status = 'cancelled';
            } elseif (strpos($log['action'], 'update') !== false && strpos($log['description'], 'completed') !== false) {
                $status = 'completed';
            } elseif (strpos($log['action'], 'create') !== false) {
                $status = 'pending';
            }

            $bookingHistory[] = [
                'status' => $status,
                'description' => $log['description'],
                'created_at' => $log['created_at'],
                'admin_name' => $log['admin_name'],
                'type' => 'activity'
            ];
        }

        // Sort combined history by created_at (newest first)
        usort($bookingHistory, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        // If no history found, create a default entry based on booking status
        if (empty($bookingHistory)) {
            $bookingHistory[] = [
                'status' => $booking['booking_status'],
                'description' => 'Đặt tour ' . $booking['booking_number'],
                'created_at' => $booking['created_at'],
                'admin_name' => null,
                'type' => 'system'
            ];
        }

        // 8. Get invoice if available
        $invoiceSql = "SELECT * FROM invoices WHERE booking_id = :booking_id LIMIT 1";
        $invoiceStmt = $this->db->prepare($invoiceSql);
        $invoiceStmt->bindParam(':booking_id', $id, \PDO::PARAM_INT);
        $invoiceStmt->execute();
        $invoice = $invoiceStmt->fetch(\PDO::FETCH_ASSOC);

        // Return all information as a structured array
        return [
            'booking' => $booking,
            'tour' => $tour,
            'payments' => $payments,
            'latest_payment' => $payment,
            'booking_history' => $bookingHistory,
            'invoice' => $invoice
        ];
    }

    public function findBy($column, $value, $jsonSearch = false)
    {
        if ($jsonSearch) {
            // Search within JSON columns
            $sql = "SELECT * FROM {$this->table} WHERE JSON_CONTAINS(payment_details, :value) LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $jsonValue = json_encode(['payment_intent_id' => $value]);
            $stmt->bindParam(':value', $jsonValue);
        } else {
            // Regular column search
            $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':value', $value);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        // Define valid columns that exist in the database
        $validColumns = [
            'booking_number',
            'user_id',
            'tour_id',
            'tour_date_id',
            'adults',
            'children',
            'total_price',
            'status',
            'payment_status',
            'payment_method',
            'transaction_id',
            'special_requirements',
            'created_at',
            'updated_at'
        ];

        $columns = [];
        $placeholders = [];
        $values = [];

        foreach ($data as $column => $value) {
            // Only include columns that exist in the database
            if (in_array($column, $validColumns)) {
                $columns[] = $column;
                $placeholders[] = ":$column";
                $values[":$column"] = $value;
            }
        }

        // Add created_at if not provided
        if (!isset($data['created_at'])) {
            $columns[] = 'created_at';
            $placeholders[] = ':created_at';
            $values[':created_at'] = date('Y-m-d H:i:s');
        }

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $this->db->prepare($sql);
        foreach ($values as $placeholder => $value) {
            $stmt->bindValue($placeholder, $value);
        }

        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function addPassenger(array $data)
    {
        // First, determine which fields actually exist in the booking_customers table
        // by checking which ones are provided in the data array
        $columns = ['booking_id', 'full_name', 'type'];
        $values = [':booking_id', ':full_name', ':type'];
        $params = [
            ':booking_id' => $data['booking_id'],
            ':full_name' => $data['full_name'],
            ':type' => $data['type'],
        ];

        // Conditionally add other fields only if they're provided and not null
        $possibleFields = [
            'email',
            'phone',
            'address',
            'passport_number',
            'date_of_birth'
        ];

        foreach ($possibleFields as $field) {
            if (isset($data[$field]) && $data[$field] !== null) {
                $columns[] = $field;
                $values[] = ":$field";
                $params[":$field"] = $data[$field];
            }
        }

        // Always add created_at
        $columns[] = 'created_at';
        $values[] = ':created_at';
        $params[':created_at'] = date('Y-m-d H:i:s');

        $sql = "INSERT INTO booking_customers (" . implode(', ', $columns) . ") 
            VALUES (" . implode(', ', $values) . ")";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Error adding passenger: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a new payment record
     * 
     * @param array $data Payment data
     * @return int|bool The ID of the new payment or false on failure
     */
    public function createPayment(array $data)
    {
        // Define valid columns for the payments table
        $validColumns = [
            'booking_id',
            'payment_method_id',
            'transaction_id',
            'transaction_id_internal',
            'refund_id',
            'amount',
            'currency',
            'status',
            'payment_data',
            'notes',
            'payer_name',
            'payer_email',
            'payer_phone',
            'payment_date',
            'created_at',
            'updated_at'
        ];

        $columns = [];
        $placeholders = [];
        $values = [];

        foreach ($data as $column => $value) {
            // Only include columns that exist in the database
            if (in_array($column, $validColumns)) {
                $columns[] = $column;
                $placeholders[] = ":$column";
                $values[":$column"] = $value;
            }
        }

        // Add created_at if not provided
        if (!isset($data['created_at'])) {
            $columns[] = 'created_at';
            $placeholders[] = ':created_at';
            $values[':created_at'] = date('Y-m-d H:i:s');
        }

        $sql = "INSERT INTO payments (" . implode(', ', $columns) . ") 
            VALUES (" . implode(', ', $placeholders) . ")";

        try {
            $stmt = $this->db->prepare($sql);
            foreach ($values as $placeholder => $value) {
                $stmt->bindValue($placeholder, $value);
            }

            $stmt->execute();
            $paymentId = $this->db->lastInsertId();

            // Log the payment creation
            $this->createPaymentLog([
                'payment_id' => $paymentId,
                'booking_id' => $data['booking_id'],
                'event' => 'payment_created',
                'status' => $data['status'],
                'message' => 'Tạo thanh toán mới',
                'data' => json_encode(['method' => $data['payment_method_id'], 'amount' => $data['amount']])
            ]);

            return $paymentId;
        } catch (\PDOException $e) {
            error_log("Error creating payment: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a payment log entry
     * 
     * @param array $data Log data
     * @return bool Success or failure
     */
    public function createPaymentLog(array $data)
    {
        $sql = "INSERT INTO payment_logs 
            (payment_id, booking_id, event, status, message, data, ip_address, created_at) 
            VALUES 
            (:payment_id, :booking_id, :event, :status, :message, :data, :ip_address, :created_at)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':payment_id', $data['payment_id'] ?? null);
            $stmt->bindValue(':booking_id', $data['booking_id']);
            $stmt->bindValue(':event', $data['event']);
            $stmt->bindValue(':status', $data['status']);
            $stmt->bindValue(':message', $data['message']);
            $stmt->bindValue(':data', $data['data'] ?? null);
            $stmt->bindValue(':ip_address', $_SERVER['REMOTE_ADDR'] ?? null);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error creating payment log: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update payment information
     * 
     * @param int $paymentId The ID of the payment
     * @param array $data The data to update
     * @return bool
     */
    public function updatePayment($paymentId, $data)
    {
        $validColumns = [
            'transaction_id',
            'transaction_id_internal',
            'amount',
            'currency',
            'status',
            'payment_data',
            'notes',
            'payment_date',
            'updated_at'
        ];

        $updates = [];
        $values = [];

        foreach ($data as $column => $value) {
            if (in_array($column, $validColumns)) {
                $updates[] = "{$column} = :{$column}";
                $values[":{$column}"] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        // Add updated_at if not provided
        if (!isset($data['updated_at'])) {
            $updates[] = "updated_at = :updated_at";
            $values[':updated_at'] = date('Y-m-d H:i:s');
        }

        $sql = "UPDATE payments SET " . implode(', ', $updates) . " WHERE id = :id";
        $values[':id'] = $paymentId;

        $stmt = $this->db->prepare($sql);
        foreach ($values as $key => &$value) {
            $stmt->bindParam($key, $value);
        }

        return $stmt->execute();
    }




    /**
     * Get payment information by booking ID
     * 
     * @param int $bookingId The booking ID
     * @return array|false Payment information or false if not found
     */
    public function getPaymentByBookingId($bookingId)
    {
        $sql = "SELECT * FROM payments WHERE booking_id = :booking_id ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':booking_id', $bookingId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get all passengers for a booking
     * 
     * @param int $bookingId The booking ID
     * @return array List of passengers
     */
    public function getBookingPassengers($bookingId)
    {
        $sql = "SELECT * FROM booking_customers WHERE booking_id = :booking_id ORDER BY type, id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':booking_id', $bookingId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get payment logs for a booking
     * 
     * @param int $bookingId The booking ID
     * @return array List of payment logs
     */
    public function getPaymentLogs($bookingId)
    {
        $sql = "SELECT * FROM payment_logs WHERE booking_id = :booking_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':booking_id', $bookingId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy booking hoàn thành theo tour và người dùng
     * 
     * @param int $tourId ID của tour
     * @param int $userId ID của người dùng
     * @return array|false Thông tin booking hoặc false nếu không tìm thấy
     */
    public function getCompletedBookingByTourAndUser($tourId, $userId)
    {
        $sql = "SELECT * FROM {$this->table} 
            WHERE tour_id = :tour_id 
            AND user_id = :user_id 
            AND status = 'completed' 
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số booking của một người dùng
     * 
     * @param int $userId ID của người dùng
     * @return int Số lượng booking
     */
    public function countUserBookings($userId)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    /**
     * Đếm số lượng booking của một người dùng theo trạng thái
     * 
     * @param int $userId ID của người dùng
     * @param string $status Trạng thái booking (completed, pending, cancelled, etc.)
     * @return int Số lượng booking có trạng thái tương ứng
     */
    public function countUserBookingsByStatus($userId, $status)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE user_id = :user_id AND status = :status";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    /**
     * Lấy danh sách booking gần đây của người dùng
     * 
     * @param int $userId ID của người dùng
     * @param int $limit Số lượng kết quả tối đa
     * @return array Danh sách các booking
     */
    public function getRecentUserBookings($userId, $limit = 5)
    {
        $sql = "SELECT b.*, t.title as tour_title, t.slug as tour_slug, i.file_path as thumbnail
            FROM {$this->table} b 
            JOIN tours t ON b.tour_id = t.id 
            JOIN tour_images ti ON t.id = ti.tour_id AND ti.is_featured = 1
            JOIN images i ON ti.image_id = i.id
            WHERE b.user_id = :user_id 
            ORDER BY b.created_at DESC 
            LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}