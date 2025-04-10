<?php

namespace App\Models;

use PDOException;
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

        // Get only image paths for each tour
        foreach ($items as &$item) {
            $imagesSql = "SELECT 
                        CASE 
                            WHEN i.cloudinary_url IS NOT NULL AND i.cloudinary_url != '' 
                            THEN i.cloudinary_url 
                            ELSE i.file_path 
                        END as image_path
                    FROM tour_images ti
                    JOIN images i ON ti.image_id = i.id
                    WHERE ti.tour_id = :tour_id
                    ORDER BY ti.is_featured DESC, ti.sort_order ASC";
            $imagesStmt = $this->db->prepare($imagesSql);
            $imagesStmt->bindValue(':tour_id', $item['id'], \PDO::PARAM_INT);
            $imagesStmt->execute();
            $item['tour_images'] = $imagesStmt->fetchAll(\PDO::FETCH_COLUMN);
        }

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
                tours.*, tour_reviews.rating,
                locations.name AS location_name,
                locations.description AS location_des,
                locations.latitude AS location_la,
                tour_categories.name AS category_name, 
                GROUP_CONCAT(images.cloudinary_url) AS images
            FROM tours
            LEFT JOIN tour_categories ON tours.category_id = tour_categories.id 
            LEFT JOIN locations ON locations.id = tours.location_id 
            LEFT JOIN tour_images ON tour_images.tour_id = tours.id
            LEFT JOIN images ON images.id = tour_images.image_id
            LEFT JOIN tour_reviews ON tour_reviews.tour_id = tours.id
            WHERE tours.id = :id
            GROUP BY tours.id,tour_reviews.rating, locations.name, locations.description, locations.latitude, 
                     tour_categories.name";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $tourId, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $result['images'] = !empty($result['images']) ? explode(',', $result['images']) : [];

        $sqlDates = "SELECT start_date, end_date, available_seats 
                 FROM tour_dates 
                 WHERE tour_id = :id";

        $stmtDates = $this->db->prepare($sqlDates);
        $stmtDates->bindValue(':id', $tourId, \PDO::PARAM_INT);
        $stmtDates->execute();

        $result['dates'] = $stmtDates->fetchAll(PDO::FETCH_ASSOC);

        return $result;
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
        return $this->db->lastInsertId();
    }

    public function attachImage($tourId, $imageId, $is_featured = null)
    {
        $sql = "INSERT INTO `tour_images` (`tour_id`, `image_id`, `is_featured` ) VALUES (:tour_id, :image_id, :is_featured)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'tour_id' => $tourId,
            'image_id' => $imageId,
            'is_featured' => $is_featured
        ]);
    }

    /**
     * Cập nhật ảnh cho tour
     * 
     * @param int $tourId ID của tour
     * @param int $imageId ID của ảnh
     * @param bool $isFeatured Có phải ảnh đại diện không
     * @return bool Kết quả cập nhật
     */
    public function updateImage($tourId, $imageId, $isFeatured = 0)
    {
        try {
            $db = $this->db;

            // Kiểm tra xem liên kết đã tồn tại chưa
            $checkSql = "SELECT id FROM tour_images WHERE tour_id = ? AND image_id = ?";
            $checkStmt = $db->prepare($checkSql);
            $checkStmt->execute([$tourId, $imageId]);
            $existingRecord = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($isFeatured) {
                // Nếu là ảnh đại diện, đặt tất cả ảnh khác của tour này thành không phải đại diện
                $resetFeaturedSql = "UPDATE tour_images SET is_featured = 0 WHERE tour_id = ?";
                $resetStmt = $db->prepare($resetFeaturedSql);
                $resetStmt->execute([$tourId]);
            }

            if ($existingRecord) {
                // Nếu liên kết đã tồn tại, chỉ cập nhật trạng thái is_featured
                $updateSql = "UPDATE tour_images SET is_featured = ? WHERE tour_id = ? AND image_id = ?";
                $updateStmt = $db->prepare($updateSql);
                $result = $updateStmt->execute([$isFeatured, $tourId, $imageId]);
            } else {
                // Thêm liên kết mới
                $sortOrder = $this->getNextSortOrder($tourId);
                $insertSql = "INSERT INTO tour_images (tour_id, image_id, is_featured, sort_order) VALUES (?, ?, ?, ?)";
                $insertStmt = $db->prepare($insertSql);
                $result = $insertStmt->execute([$tourId, $imageId, $isFeatured, $sortOrder]);
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật ảnh cho tour: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy thứ tự sắp xếp tiếp theo cho ảnh mới
     * 
     * @param int $tourId ID của tour
     * @return int Thứ tự sắp xếp tiếp theo
     */
    private function getNextSortOrder($tourId)
    {
        $sql = "SELECT MAX(sort_order) as max_order FROM tour_images WHERE tour_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tourId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result['max_order'] !== null) ? $result['max_order'] + 1 : 0;
    }

    /**
     * Xóa liên kết ảnh của tour
     * 
     * @param int $tourId ID của tour
     * @param int $imageId ID của ảnh cần xóa, nếu null sẽ xóa tất cả ảnh của tour
     * @return bool Kết quả xóa
     */
    public function removeImage($tourId, $imageId = null)
    {
        try {
            $db = $this->db;

            if ($imageId !== null) {
                // Xóa một ảnh cụ thể
                $sql = "DELETE FROM tour_images WHERE tour_id = ? AND image_id = ?";
                $stmt = $db->prepare($sql);
                return $stmt->execute([$tourId, $imageId]);
            } else {
                // Xóa tất cả ảnh của tour
                $sql = "DELETE FROM tour_images WHERE tour_id = ?";
                $stmt = $db->prepare($sql);
                return $stmt->execute([$tourId]);
            }
        } catch (PDOException $e) {
            error_log("Lỗi xóa ảnh cho tour: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Đặt tất cả ảnh của tour thành không phải ảnh đại diện
     * 
     * @param int $tourId ID của tour
     * @return bool Kết quả
     */
    public function resetFeaturedImages($tourId)
    {
        try {
            $sql = "UPDATE tour_images SET is_featured = 0 WHERE tour_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$tourId]);
        } catch (PDOException $e) {
            error_log("Lỗi reset ảnh đại diện: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy tất cả ảnh không phải ảnh đại diện của tour
     * 
     * @param int $tourId ID của tour
     * @return array Danh sách ảnh
     */
    public function getAllImagesExcludingFeatured($tourId)
    {
        try {
            $sql = "SELECT i.*, ti.image_id, ti.is_featured 
                FROM tour_images ti 
                JOIN images i ON ti.image_id = i.id 
                WHERE ti.tour_id = ? AND ti.is_featured = 0 
                ORDER BY ti.sort_order ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$tourId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy danh sách ảnh chi tiết: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy ảnh đại diện của tour
     * 
     * @param int $tourId ID của tour
     * @return array|null Thông tin ảnh đại diện hoặc null nếu không có
     */
    public function getFeaturedImageByTourId($tourId)
    {
        try {
            $sql = "SELECT i.*, ti.image_id, ti.is_featured 
                FROM tour_images ti 
                JOIN images i ON ti.image_id = i.id 
                WHERE ti.tour_id = ? AND ti.is_featured = 1 
                LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$tourId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy ảnh đại diện: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get image ID by a cloudinary identifier (usually the file name or public ID)
     * 
     * @param string $identifier The cloudinary identifier (from URL or public ID)
     * @return int|null The image ID or null if not found
     */
    public function getImageIdByIdentifier($identifier)
    {
        // Strip path and extension if present
        $cleanIdentifier = basename($identifier);
        $cleanIdentifier = preg_replace('/\.[^.]+$/', '', $cleanIdentifier);

        $sql = "SELECT id FROM images WHERE 
            cloudinary_id LIKE :identifier OR 
            cloudinary_url LIKE :url OR
            file_name LIKE :filename";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':identifier', "%$cleanIdentifier%", PDO::PARAM_STR);
            $stmt->bindValue(':url', "%$cleanIdentifier%", PDO::PARAM_STR);
            $stmt->bindValue(':filename', "%$cleanIdentifier%", PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id'] : null;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
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

    public function getTourDateById($id)
    {
        $sql = "SELECT * FROM tour_dates WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTourDate($tourId, $data)
    {
        $sql = "INSERT INTO tour_dates (tour_id, start_date, end_date, available_seats) 
            VALUES (:tour_id, :start_date, :end_date, :available_seats)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':tour_id' => $tourId,
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':available_seats' => $data['available_seats'],
        ]);
    }


    public function updateTourDate($tourDateId, $data)
    {
        $setClause = implode(', ', array_map(fn($key) => "`$key` = :$key", array_keys($data)));
        $sql = "UPDATE `tour_dates` SET $setClause WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $tourDateId;
        return $stmt->execute($data);
    }

    /**
     * Lấy tất cả lịch khởi hành cho một tour cụ thể
     * 
     * @param int $tourId ID của tour
     * @return array Mảng các lịch khởi hành
     */
    public function getTourDates($tourId)
    {
        $sql = "SELECT * FROM `tour_dates` WHERE `tour_id` = :tour_id ORDER BY `start_date` ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Xóa một lịch khởi hành theo ID
     * 
     * @param int $dateId ID của lịch khởi hành cần xóa
     * @return bool Thành công hay thất bại
     */
    public function deleteTourDate($dateId)
    {
        $sql = "DELETE FROM `tour_dates` WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $dateId]);
    }

    public function getTours($filters = [], $sortOption = 'default', $onlySalePrice = false, $limit = null, $offset = null)
    {
        $currentDate = date('Y-m-d');

        // Các bảng join mặc định
        $joins = [
            "JOIN tour_categories ON tour_categories.id = tours.category_id",
            "JOIN locations ON locations.id = tours.location_id",
            "LEFT JOIN (
            SELECT tour_id, AVG(rating) as avg_rating, COUNT(*) as review_count 
            FROM tour_reviews 
            GROUP BY tour_id
        ) as tr ON tr.tour_id = tours.id",
            "LEFT JOIN tour_dates ON tour_dates.tour_id = tours.id",
            "LEFT JOIN (SELECT tour_id, image_id FROM tour_images WHERE is_featured = 1) AS tour_images ON tour_images.tour_id = tours.id",
            "LEFT JOIN images ON tour_images.image_id = images.id"
        ];

        // Các cột mặc định cần lấy
        $columns = "tours.id, tours.description, 
        tour_images.tour_id, tour_images.image_id,
        images.cloudinary_url,
        tr.avg_rating, 
        tr.review_count,
        tours.title, tours.price, tours.duration, tours.sale_price,
        MIN(CASE WHEN tour_dates.start_date >= '$currentDate' THEN tour_dates.start_date ELSE NULL END) as next_start_date,
        MIN(CASE WHEN tour_dates.end_date >= '$currentDate' THEN tour_dates.end_date ELSE NULL END) as next_end_date,
        COUNT(DISTINCT tour_dates.id) as date_count,
        GROUP_CONCAT(DISTINCT CONCAT(tour_dates.start_date, '|', tour_dates.end_date) ORDER BY tour_dates.start_date) as all_dates,
        tour_categories.name AS category_name, 
        locations.name AS location_name";

        // GROUP BY mặc định
        $groupBy = "GROUP BY tours.id, tour_images.tour_id, tour_images.image_id, images.cloudinary_url, tr.avg_rating, tr.review_count, tours.title, tours.price, tours.duration, tours.sale_price, tour_categories.name, locations.name";

        // Điều kiện lọc mặc định
        $conditions = ["tours.status" => "active"];

        // Thêm điều kiện sale_price > 0 nếu được yêu cầu
        if ($onlySalePrice) {
            $conditions["tours.sale_price"] = "> 0";
        }

        // Thêm các điều kiện lọc từ tham số
        if (!empty($filters['category_id'])) {
            $conditions["tours.category_id"] = $filters['category_id'];
        }

        if (!empty($filters['location_id'])) {
            $conditions["tours.location_id"] = $filters['location_id'];
        }

        if (!empty($filters['featured'])) {
            $conditions["tours.featured"] = $filters['featured'];
        }

        // Thêm điều kiện lọc theo danh sách ID tour
        if (!empty($filters['tour_ids']) && is_array($filters['tour_ids'])) {
            // Chuyển đổi mảng ID thành chuỗi cho SQL IN clause
            $conditions["custom_where"] = "tours.id IN (" . implode(',', array_map('intval', $filters['tour_ids'])) . ")";
        }

        // Phần còn lại của hàm giữ nguyên như cũ
        // Xây dựng điều kiện HAVING cho các bộ lọc nâng cao
        $having = "";

        // Lọc theo giá
        if (!empty($filters['price_ranges'])) {
            $priceConditions = [];
            foreach ($filters['price_ranges'] as $range) {
                list($min, $max) = explode('-', $range);
                if ($max === 'max') {
                    $priceConditions[] = "(CASE WHEN tours.sale_price > 0 THEN tours.sale_price ELSE tours.price END >= $min)";
                } else {
                    $priceConditions[] = "(CASE WHEN tours.sale_price > 0 THEN tours.sale_price ELSE tours.price END BETWEEN $min AND $max)";
                }
            }
            if (!empty($priceConditions)) {
                $having .= (!empty($having) ? " AND " : "") . "(" . implode(" OR ", $priceConditions) . ")";
            }
        }

        // Lọc theo thời lượng
        if (!empty($filters['durations'])) {
            $durationConditions = [];
            foreach ($filters['durations'] as $duration) {
                list($min, $max) = explode('-', $duration);
                if ($max === 'max') {
                    $durationConditions[] = "(tours.duration >= $min)";
                } else {
                    $durationConditions[] = "(tours.duration BETWEEN $min AND $max)";
                }
            }
            if (!empty($durationConditions)) {
                $having .= (!empty($having) ? " AND " : "") . "(" . implode(" OR ", $durationConditions) . ")";
            }
        }

        // Lọc theo đánh giá
        if (!empty($filters['ratings'])) {
            $ratingConditions = [];
            foreach ($filters['ratings'] as $rating) {
                $ratingConditions[] = "(tr.avg_rating >= $rating)";
            }
            if (!empty($ratingConditions)) {
                $having .= (!empty($having) ? " AND " : "") . "(" . implode(" OR ", $ratingConditions) . ")";
            }
        }

        // Lọc theo từ khóa (nếu có)
        if (!empty($filters['keyword'])) {
            $keyword = $filters['keyword'];
            $conditions["tours.title"] = "LIKE %{$keyword}%";
        }

        // Xác định cách sắp xếp
        $orderBy = 'tours.id DESC';
        switch ($sortOption) {
            case 'popular':
                $orderBy = 'tr.review_count DESC, tr.avg_rating DESC';
                break;
            case 'price_asc':
                $orderBy = 'CASE WHEN tours.sale_price > 0 THEN tours.sale_price ELSE tours.price END ASC';
                break;
            case 'price_desc':
                $orderBy = 'CASE WHEN tours.sale_price > 0 THEN tours.sale_price ELSE tours.price END DESC';
                break;
            case 'rating':
                $orderBy = 'tr.avg_rating DESC, tr.review_count DESC';
                break;
        }

        // Thực hiện truy vấn sử dụng hàm getAll
        return $this->getAll(
            $columns,
            $conditions,
            $orderBy,
            $limit,
            $offset,
            $joins,
            $groupBy,
            $having
        );
    }

    public function getFeaturedTours($limit = 3, $onlySalePrice = false)
    {
        return $this->getTours(['featured' => 1], 'default', $onlySalePrice, $limit);
    }
}
