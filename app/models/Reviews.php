<?php


namespace App\Models;

use PDO;

class Reviews extends BaseModel
{
    protected $table = 'tour_reviews';

    public function __construct()
    {
        parent::__construct();
    }
    public function getTourReviews($reviewId = null, $filters = [])
    {
        $db = $this->db;

        // Xây dựng truy vấn cơ bản
        $query = "SELECT tr.*, 
                    t.title AS tour_title, 
                    t.slug AS tour_slug, 
                    t.duration AS tour_duration,
                    t.price AS tour_price, 
                    t.sale_price AS tour_sale_price,
                    t.description AS tour_description,
                    u.username, 
                    u.email, 
                    u.full_name, 
                    u.avatar,
                    u.phone AS user_phone
              FROM tour_reviews tr
              LEFT JOIN tours t ON tr.tour_id = t.id
              LEFT JOIN users u ON tr.user_id = u.id";

        // Thêm điều kiện truy vấn
        $whereConditions = [];
        $params = [];

        // Nếu có reviewId, chỉ lấy đánh giá cụ thể đó
        if ($reviewId !== null) {
            $whereConditions[] = "tr.id = :review_id";
            $params[':review_id'] = $reviewId;
        }

        // Xử lý các điều kiện lọc bổ sung
        if (isset($filters['tour_id'])) {
            $whereConditions[] = "tr.tour_id = :tour_id";
            $params[':tour_id'] = $filters['tour_id'];
        }

        if (isset($filters['user_id'])) {
            $whereConditions[] = "tr.user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }

        if (isset($filters['status'])) {
            $whereConditions[] = "tr.status = :status";
            $params[':status'] = $filters['status'];
        }

        if (isset($filters['rating'])) {
            $whereConditions[] = "tr.rating = :rating";
            $params[':rating'] = $filters['rating'];
        }

        if (isset($filters['min_rating'])) {
            $whereConditions[] = "tr.rating >= :min_rating";
            $params[':min_rating'] = $filters['min_rating'];
        }

        // Thêm các điều kiện WHERE nếu có
        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }

        // Sắp xếp kết quả
        $query .= " ORDER BY tr.created_at DESC";

        // Xử lý giới hạn và phân trang
        if (isset($filters['limit'])) {
            $query .= " LIMIT :offset, :limit";
            $params[':limit'] = $filters['limit'];
            $params[':offset'] = isset($filters['offset']) ? $filters['offset'] : 0;
        }

        // Chuẩn bị và thực thi truy vấn
        $stmt = $db->prepare($query);

        // Ràng buộc các tham số
        foreach ($params as $param => $value) {
            if (is_int($value)) {
                $stmt->bindValue($param, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($param, $value, PDO::PARAM_STR);
            }
        }

        $stmt->execute();

        // Xử lý kết quả
        if ($reviewId !== null) {
            // Trả về một đánh giá cụ thể
            $review = $stmt->fetch(PDO::FETCH_ASSOC);

            // Đảm bảo các trường đều có giá trị mặc định nếu NULL
            $defaultFields = [
                'title',
                'review',
                'tour_title',
                'tour_description',
                'username',
                'full_name',
                'avatar',
                'user_phone'
            ];

            foreach ($defaultFields as $field) {
                if (!isset($review[$field]) || $review[$field] === null) {
                    $review[$field] = '';
                }
            }

            return $review;
        } else {
            // Trả về danh sách các đánh giá
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Đảm bảo các trường đều có giá trị mặc định cho mỗi đánh giá
            foreach ($reviews as &$review) {
                $defaultFields = [
                    'title',
                    'review',
                    'tour_title',
                    'tour_description',
                    'username',
                    'full_name',
                    'avatar',
                    'user_phone'
                ];

                foreach ($defaultFields as $field) {
                    if (!isset($review[$field]) || $review[$field] === null) {
                        $review[$field] = '';
                    }
                }
            }

            return $reviews;
        }
    }
    public function deleteById($id, $tb)
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("DELETE FROM {$tb} WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    /**
     * Lấy thông tin chi tiết của một đánh giá tour theo ID
     * @param int $reviewId ID của đánh giá cần lấy thông tin
     * @return array Thông tin chi tiết của đánh giá kèm dữ liệu từ các bảng liên quan
     */
    public function getTourReviewById($reviewId)
    {
        $db = $this->db;

        $query = "SELECT tr.*, 
                    t.title as tour_title, t.slug as tour_slug, t.price as tour_price,
                    t.duration as tour_duration, t.group_size as tour_group_size,
                    u.username, u.email,
                    CONCAT(u.full_name) as user_full_name,
                    u.avatar as user_avatar, u.phone as user_phone
              FROM tour_reviews tr
              LEFT JOIN tours t ON tr.tour_id = t.id
              LEFT JOIN users u ON tr.user_id = u.id
              WHERE tr.id = :id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);
        $stmt->execute();

        $review = $stmt->fetch(PDO::FETCH_ASSOC);

        // Đảm bảo tất cả các trường đều có giá trị mặc định nếu NULL
        $defaultFields = [
            'title',
            'review',
            'rating',
            'user_full_name',
            'tour_title',
            'user_avatar',
            'user_phone'
        ];

        foreach ($defaultFields as $field) {
            if (!isset($review[$field]) || $review[$field] === null) {
                $review[$field] = '';
            }
        }

        // Đảm bảo trường rating luôn là số nếu NULL
        if (!isset($review['rating']) || $review['rating'] === null) {
            $review['rating'] = 0;
        }

        return $review;
    }
    public function updateStatus($reviewId, $status)
    {
        $sql = "UPDATE {$this->table} 
                SET status = :status, updated_at = NOW() 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Lấy đánh giá bởi tour và user
     * 
     * @param int $tourId ID của tour
     * @param int $userId ID của người dùng
     * @return array|false Thông tin đánh giá hoặc false nếu không tồn tại
     */
    public function getByTourAndUser($tourId, $userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tour_id = :tour_id AND user_id = :user_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy đánh giá dựa trên booking và user
     * 
     * @param int $bookingId ID của booking
     * @param int $userId ID của người dùng
     * @return array|false Thông tin đánh giá hoặc false nếu không tồn tại
     */
    public function getByBookingAndUser($bookingId, $userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE booking_id = :booking_id AND user_id = :user_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':booking_id', $bookingId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo đánh giá mới
     * 
     * @param array $data Dữ liệu đánh giá
     * @return int|false ID của đánh giá mới hoặc false nếu thất bại
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (
        user_id, tour_id, booking_id, rating, title, review, status, created_at, updated_at
    ) VALUES (
        :user_id, :tour_id, :booking_id, :rating, :title, :review, :status, :created_at, :updated_at
    )";

        // Đảm bảo có title nếu không được cung cấp
        if (!isset($data['title']) || empty($data['title'])) {
            $data['title'] = 'Đánh giá về tour';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':tour_id', $data['tour_id'], PDO::PARAM_INT);
        $stmt->bindValue(':booking_id', $data['booking_id'], PDO::PARAM_INT);
        $stmt->bindValue(':rating', $data['rating'], PDO::PARAM_INT);
        $stmt->bindValue(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindValue(':review', $data['comment'] ?? $data['review'] ?? '', PDO::PARAM_STR); // Sửa từ comment sang review
        $stmt->bindValue(':status', $data['status'] ?? 'pending', PDO::PARAM_STR); // Đặt mặc định là pending
        $stmt->bindValue(':created_at', $data['created_at'], PDO::PARAM_STR);
        $stmt->bindValue(':updated_at', $data['updated_at'], PDO::PARAM_STR);

        try {
            $this->db->beginTransaction();
            $stmt->execute();
            $id = $this->db->lastInsertId();
            $this->db->commit();
            return $id;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    /**
     * Cập nhật đánh giá
     * 
     * @param int $id ID của đánh giá cần cập nhật
     * @param array $data Dữ liệu cập nhật
     * @return bool Kết quả cập nhật
     */
    public function update($id, $data)
    {
        // Xây dựng câu lệnh SQL động dựa trên dữ liệu được cung cấp
        $sql = "UPDATE {$this->table} SET ";
        $updateFields = [];
        $params = [':id' => $id];

        foreach ($data as $field => $value) {
            if ($field !== 'id') { // Không cập nhật trường ID
                $updateFields[] = "$field = :$field";
                $params[":$field"] = $value;
            }
        }

        $sql .= implode(', ', $updateFields);
        $sql .= " WHERE id = :id";

        try {
            $stmt = $this->db->prepare($sql);
            foreach ($params as $param => $value) {
                if (is_int($value)) {
                    $stmt->bindValue($param, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($param, $value, PDO::PARAM_STR);
                }
            }

            $this->db->beginTransaction();
            $result = $stmt->execute();
            $this->db->commit();
            return $result;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Tính điểm đánh giá trung bình của một tour
     * 
     * @param int $tourId ID của tour
     * @return float Điểm đánh giá trung bình
     */
    public function getAverageRating($tourId)
    {
        $sql = "SELECT AVG(rating) FROM {$this->table} WHERE tour_id = :tour_id AND status = 'approved'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->execute();

        $avg = $stmt->fetchColumn();
        return $avg ? round($avg, 1) : 0;
    }

    /**
     * Đếm số lượng đánh giá của một tour
     * 
     * @param int $tourId ID của tour
     * @return int Số lượng đánh giá
     */
    public function countByTour($tourId)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE tour_id = :tour_id AND status = 'approved'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tour_id', $tourId, PDO::PARAM_INT);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    /**
     * Đếm số lượng đánh giá của một người dùng
     * 
     * @param int $userId ID của người dùng
     * @return int Số lượng đánh giá
     */
    public function countUserReviews($userId)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    /**
     * Tính điểm đánh giá trung bình của người dùng
     * 
     * @param int $userId ID của người dùng
     * @return float Điểm đánh giá trung bình
     */
    public function getUserAverageRating($userId)
    {
        $sql = "SELECT AVG(rating) FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $avg = $stmt->fetchColumn();
        return $avg ? round((float)$avg, 1) : 0;
    }

    /**
     * Lấy các đánh giá gần đây của người dùng
     * 
     * @param int $userId ID của người dùng
     * @param int $limit Số lượng kết quả tối đa
     * @return array Danh sách các đánh giá
     */
    public function getRecentUserReviews($userId, $limit = 5)
    {
        $sql = "SELECT r.*, t.title as tour_title, t.slug as tour_slug, i.file_path as thumbnail
            FROM {$this->table} r
            JOIN tours t ON r.tour_id = t.id
            JOIN tour_images ti ON t.id = ti.tour_id AND ti.is_featured = 1
            JOIN images i ON ti.image_id = i.id
            WHERE r.user_id = :user_id
            ORDER BY r.created_at DESC
            LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}