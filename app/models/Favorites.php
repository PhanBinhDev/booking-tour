<?php

namespace App\Models;

use PDO;

class Favorites extends BaseModel
{
    protected $table = 'favorites';

    public function __construct()
    {
        parent::__construct();
    }

    public function addFavorite($userId, $tourId)
    {
        // Check if already exists
        if ($this->checkFavoriteExists($userId, $tourId)) {
            return false;
        }

        $query = "INSERT INTO favorites (user_id, tour_id) VALUES (:user_id, :tour_id)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':tour_id', $tourId);
        return $stmt->execute();
    }

    public function removeFavorite($userId, $tourId)
    {
        $query = "DELETE FROM favorites WHERE user_id = :user_id AND tour_id = :tour_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':tour_id', $tourId);
        return $stmt->execute();
    }

    public function checkFavoriteExists($userId, $tourId)
    {
        $query = "SELECT id FROM favorites WHERE user_id = :user_id AND tour_id = :tour_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':tour_id', $tourId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($result);
    }

    public function getFavoritesByUser($userId)
    {
        $query = "SELECT f.*, t.title, t.price, t.sale_price, t.duration, t.slug, t.featured 
                 FROM favorites f 
                 JOIN tours t ON f.tour_id = t.id 
                 WHERE f.user_id = :user_id
                 ORDER BY f.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUserFavorites($userId)
    {
        $query = "SELECT COUNT(*) as count FROM favorites WHERE user_id = :user_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getFavoriteTourIdsByUser($userId)
    {
        $sql = "SELECT tour_id FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $results;
    }
}
