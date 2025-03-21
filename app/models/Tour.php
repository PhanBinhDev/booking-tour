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

    public function getTourDetails($tourId)
    {
        $sql = "SELECT 
                tours.*, 
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
