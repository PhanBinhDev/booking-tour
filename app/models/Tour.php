<?php

namespace App\Models;

use PDO;

class Tour extends BaseModel
{
    protected $table = 'tours';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get paginated tours with optional filters
     * 
     * @param int $page Page number
     * @param int $limit Items per page
     * @param array $filters Optional filters (status, category_id, location_id, price_min, price_max, duration, featured)
     * @param string $sort Field to sort by (default: created_at)
     * @param string $direction Sort direction (asc or desc, default: desc)
     * @return array Paginated tours with pagination metadata
     */
    public function getPaginated($page = 1, $limit = 10, $filters = [], $sortBy = 'created_at', $sortOrder = 'desc')
    {
        $offset = ($page - 1) * $limit;

        // Build the base query
        $sql = "SELECT t.id, t.title, t.slug, t.description, t.duration, t.group_size, 
                       t.price, t.sale_price, t.status, t.featured, t.views, 
                       t.created_at, t.updated_at, 
                       tc.name as category_name, l.name as location_name, 
                       dl.name as departure_location_name
                FROM {$this->table} t
                LEFT JOIN tour_categories tc ON t.category_id = tc.id
                LEFT JOIN locations l ON t.location_id = l.id
                LEFT JOIN locations dl ON t.departure_location_id = dl.id
                WHERE 1=1";

        $countSql = "SELECT COUNT(*) as total
                     FROM {$this->table} t
                     LEFT JOIN tour_categories tc ON t.category_id = tc.id
                     LEFT JOIN locations l ON t.location_id = l.id
                     LEFT JOIN locations dl ON t.departure_location_id = dl.id
                     WHERE 1=1";

        $params = [];
        $countParams = [];

        // Apply filters
        if (!empty($filters['status'])) {
            $sql .= " AND t.status = :status";
            $countSql .= " AND t.status = :status";
            $params[':status'] = $filters['status'];
            $countParams[':status'] = $filters['status'];
        }

        if (!empty($filters['category_id'])) {
            $sql .= " AND t.category_id = :category_id";
            $countSql .= " AND t.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
            $countParams[':category_id'] = $filters['category_id'];
        }

        if (!empty($filters['location_id'])) {
            $sql .= " AND t.location_id = :location_id";
            $countSql .= " AND t.location_id = :location_id";
            $params[':location_id'] = $filters['location_id'];
            $countParams[':location_id'] = $filters['location_id'];
        }

        // Add sorting and pagination
        $sql .= " GROUP BY t.id, t.title, t.slug, t.description, t.duration, t.group_size, 
                         t.price, t.sale_price, t.status, t.featured, t.views, 
                         t.created_at, t.updated_at, 
                         tc.name, l.name, dl.name
                  ORDER BY t.{$sortBy} {$sortOrder}
                  LIMIT :limit OFFSET :offset";
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

    public function getTourDetails($tourId)
    {
        $sql = "SELECT 
                tours.*, 
                locations.name AS location_name,
                locations.description AS location_des,
                locations.latitude AS location_la,
                tour_categories.name AS category_name, 
                tour_dates.start_date, 
                tour_dates.end_date 
            FROM tours
            LEFT JOIN tour_categories ON tours.category_id = tour_categories.id 
            LEFT JOIN tour_dates ON tour_dates.tour_id = tours.id 
            LEFT JOIN locations ON locations.id = tours.location_id 
            WHERE tours.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $tourId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    /**
     * Retrieves the most popular tours based on bookings and ratings.
     *
     * This function fetches a list of active tours, ordered by the number of bookings
     * and average rating. It includes details such as tour information, booking count,
     * average rating, review count, and a featured image URL.
     *
     * @param int $limit The maximum number of tours to retrieve. Defaults to 5.
     *
     * @return array An array of associative arrays, each containing details of a popular tour:
     *               - id: The tour ID
     *               - title: The tour title
     *               - duration: The tour duration
     *               - price: The regular price of the tour
     *               - sale_price: The discounted price of the tour (if applicable)
     *               - bookings: The number of bookings for this tour
     *               - rating: The average rating of the tour
     *               - reviews: The number of reviews for the tour
     *               - image: The URL of the featured image for the tour
     */
    public function getPopular($limit = 5)
    {
        $sql = "
            SELECT 
                t.id,
                t.title,
                t.duration,
                t.price,
                t.sale_price,
                COUNT(DISTINCT b.id) as bookings,
                COALESCE(AVG(tr.rating), 0) as rating,
                COUNT(DISTINCT tr.id) as reviews,
                (SELECT i.cloudinary_url 
                FROM tour_images ti 
                JOIN images i ON ti.image_id = i.id 
                WHERE ti.tour_id = t.id AND ti.is_featured = 1 
                LIMIT 1) as image
            FROM 
                {$this->table} t
            LEFT JOIN 
                bookings b ON t.id = b.tour_id
            LEFT JOIN 
                tour_reviews tr ON t.id = tr.tour_id
            WHERE 
                t.status = 'active'
            GROUP BY 
                t.id
            ORDER BY 
                bookings DESC, rating DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAvailableTourDates($tourId)
    {
        // Get current date
        $today = date('Y-m-d');

        // Update past dates automatically
        $this->updateTourDateStatuses();

        // Get available tour dates that haven't passed yet
        $sql = "SELECT * FROM tour_dates 
            WHERE tour_id = ? 
            AND start_date >= ? 
            AND status = 'available' 
            AND available_seats > 0
            ORDER BY start_date ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tourId, $today]);
        return $stmt->fetchAll();
    }

    public function updateTourDateStatuses()
    {
        // Get current date
        $today = date('Y-m-d');

        // Update status for dates that have passed
        $sql = "UPDATE tour_dates 
            SET status = 'cancelled' 
            WHERE start_date < ? 
            AND status = 'available'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$today]);
        return $stmt->rowCount();
    }

    public function getTourReviews($tourId)
    {
        $sql = "SELECT r.*, u.full_name, u.avatar
            FROM tour_reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.tour_id = ? AND r.status = 'approved'
            ORDER BY r.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tourId]);
        return $stmt->fetchAll();
    }

    public function canUserReviewTour($userId, $tourId)
    {
        // Check if user has booked and completed this tour
        $sql = "SELECT COUNT(*) FROM bookings 
            WHERE user_id = ? AND tour_id = ? AND status = 'completed' 
            AND id NOT IN (SELECT booking_id FROM tour_reviews WHERE user_id = ? AND tour_id = ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $tourId, $userId, $tourId]);
        return $stmt->fetchColumn() > 0;
    }

    public function saveReview($data)
    {
        $sql = "INSERT INTO tour_reviews 
            (tour_id, user_id, booking_id, rating, title, review) 
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['user_id'],
            $data['booking_id'],
            $data['rating'],
            $data['title'],
            $data['review']
        ]);
    }


    public function insertTour($data)
    {
        $sql = "INSERT INTO `tours` (
                    `title`, `slug`, `description`, `content`, `duration`, `group_size`, `price`, `sale_price`, 
                    `category_id`, `location_id`, `departure_location_id`, `included`, `excluded`, `itinerary`, 
                    `meta_title`, `meta_description`, `status`, `featured`, `views`, `created_by`, `updated_by`, `created_at`, `updated_at`
                ) VALUES (
                    :title, :slug, :description, :content, :duration, :group_size, :price, :sale_price, 
                    :category_id, :location_id, :departure_location_id, :included, :excluded, :itinerary, 
                    :meta_title, :meta_description, :status, :featured, :views, :created_by, :updated_by, NOW(), NOW()
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }

    public function updateTour($data)
    {
        try {
            $sql = "UPDATE `tours` 
                SET `title` = :title, 
                    `slug` = :slug, 
                    `description` = :description, 
                    `content` = :content, 
                    `duration` = :duration, 
                    `group_size` = :group_size, 
                    `price` = :price, 
                    `sale_price` = :sale_price, 
                    `category_id` = NULLIF(:category_id, ''), 
                    `location_id` = NULLIF(:location_id, ''), 
                    `departure_location_id` = NULLIF(:departure_location_id, ''), 
                    `included` = :included, 
                    `excluded` = :excluded, 
                    `itinerary` = :itinerary, 
                    `meta_title` = :meta_title, 
                    `meta_description` = :meta_description, 
                    `status` = :status, 
                    `featured` = COALESCE(:featured, 0), 
                    `updated_by` = :updated_by, 
                    `updated_at` = NOW() 
                WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($data);

            if ($result && $stmt->rowCount() > 0) {
                return true;
            } else {
                // Ghi log lỗi hoặc trả về thông báo lỗi
                error_log("Không có dòng nào được cập nhật: " . print_r($data, true));
                return false;
            }
        } catch (\Exception $e) {
            error_log("Lỗi SQL: " . $e->getMessage());
            return false;
        }
    }
}
