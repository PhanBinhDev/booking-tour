<?php

namespace App\Models;

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
        $sql = "SELECT b.*, t.name as tour_name, t.destination, t.duration
                FROM {$this->table} b
                LEFT JOIN tours t ON b.tour_id = t.id
                WHERE 1=1";

        $countSql = "SELECT COUNT(*) as total FROM {$this->table} b WHERE 1=1";

        $params = [];
        $countParams = [];

        // Apply filters
        if (!empty($filters['search'])) {
            $searchCondition = " AND (b.booking_number LIKE :search OR b.customer_name LIKE :search OR b.customer_email LIKE :search OR b.customer_phone LIKE :search)";
            $sql .= $searchCondition;
            $countSql .= $searchCondition;
            $params[':search'] = '%' . $filters['search'] . '%';
            $countParams[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= " AND b.status = :status";
            $countSql .= " AND b.status = :status";
            $params[':status'] = $filters['status'];
            $countParams[':status'] = $filters['status'];
        }

        if (!empty($filters['payment_status'])) {
            $sql .= " AND b.payment_status = :payment_status";
            $countSql .= " AND b.payment_status = :payment_status";
            $params[':payment_status'] = $filters['payment_status'];
            $countParams[':payment_status'] = $filters['payment_status'];
        }

        if (!empty($filters['tour_id'])) {
            $sql .= " AND b.tour_id = :tour_id";
            $countSql .= " AND b.tour_id = :tour_id";
            $params[':tour_id'] = $filters['tour_id'];
            $countParams[':tour_id'] = $filters['tour_id'];
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND b.user_id = :user_id";
            $countSql .= " AND b.user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
            $countParams[':user_id'] = $filters['user_id'];
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND b.departure_date >= :date_from";
            $countSql .= " AND b.departure_date >= :date_from";
            $params[':date_from'] = $filters['date_from'];
            $countParams[':date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND b.departure_date <= :date_to";
            $countSql .= " AND b.departure_date <= :date_to";
            $params[':date_to'] = $filters['date_to'];
            $countParams[':date_to'] = $filters['date_to'];
        }

        if (!empty($filters['created_from'])) {
            $sql .= " AND b.created_at >= :created_from";
            $countSql .= " AND b.created_at >= :created_from";
            $params[':created_from'] = $filters['created_from'] . ' 00:00:00';
            $countParams[':created_from'] = $filters['created_from'] . ' 00:00:00';
        }

        if (!empty($filters['created_to'])) {
            $sql .= " AND b.created_at <= :created_to";
            $countSql .= " AND b.created_at <= :created_to";
            $params[':created_to'] = $filters['created_to'] . ' 23:59:59';
            $countParams[':created_to'] = $filters['created_to'] . ' 23:59:59';
        }

        // Add sorting
        $sql .= " ORDER BY b.created_at DESC";

        // Add pagination
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

        return [
            'items' => $items,
            'pagination' => [
                'total' => $total,
                'per_page' => $limit,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'has_next_page' => $hasNextPage,
                'has_prev_page' => $hasPrevPage
            ]
        ];
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


    public function deleteById($id)
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("DELETE FROM bookings WHERE id = :id");
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
