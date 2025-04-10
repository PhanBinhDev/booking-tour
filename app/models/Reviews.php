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
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
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
}
