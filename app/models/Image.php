<?php

namespace App\Models;

use PDO;

/**
 * Image Model
 */
class Image extends BaseModel
{
    protected $table = 'images';
    protected $primaryKey = 'id';

    /**
     * Get all images with user information
     * 
     * @return array List of images with user details
     */
    public function getAllWithUsers()
    {
        $sql = "SELECT i.*, u.full_name as user_name, u.email as user_email 
                FROM {$this->table} i 
                LEFT JOIN users u ON i.user_id = u.id 
                ORDER BY i.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get images by user ID
     * 
     * @param int $userId User ID
     * @return array List of user's images
     */
    public function getUserImages($userId)
    {
        $sql = "SELECT i.* 
                FROM {$this->table} i 
                WHERE i.user_id = :user_id 
                ORDER BY i.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Create new image record
     * 
     * @param array $data Image data
     * @return int|bool New image ID or false on failure
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (
                    title, 
                    description,
                    file_name,
                    file_path,
                    file_size,
                    file_type,
                    width,
                    height,
                    alt_text,
                    cloudinary_id,
                    cloudinary_url,
                    user_id,
                    created_at,
                    updated_at
                ) VALUES (
                    :title,
                    :description,
                    :file_name,
                    :file_path,
                    :file_size,
                    :file_type,
                    :width,
                    :height,
                    :alt_text,
                    :cloudinary_id,
                    :cloudinary_url,
                    :user_id,
                    NOW(),
                    NOW()
                )";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':title', $data['title'] ?? null);
        $stmt->bindValue(':description', $data['description'] ?? null);
        $stmt->bindValue(':file_name', $data['file_name']);
        $stmt->bindValue(':file_path', $data['file_path']);
        $stmt->bindValue(':file_size', $data['file_size'] ?? null);
        $stmt->bindValue(':file_type', $data['file_type'] ?? null);
        $stmt->bindValue(':width', $data['width'] ?? null);
        $stmt->bindValue(':height', $data['height'] ?? null);
        $stmt->bindValue(':alt_text', $data['alt_text'] ?? null);
        $stmt->bindValue(':cloudinary_id', $data['cloudinary_id'] ?? null);
        $stmt->bindValue(':cloudinary_url', $data['cloudinary_url'] ?? null);
        $stmt->bindValue(':user_id', $data['user_id']);

        $stmt->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Update image record
     * 
     * @param int $id Image ID
     * @param array $data Updated image data
     * @return bool Success status
     */
    public function update($id, $data, $is_featured = null)
    {
        $sql = "UPDATE {$this->table} SET 
            title = :title,
            description = :description,
            alt_text = :alt_text,
            updated_at = NOW()";

        if ($is_featured !== null) {
            $sql .= ", is_featured = :is_featured";
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':title', $data['title'] ?? null);
        $stmt->bindValue(':description', $data['description'] ?? null);
        $stmt->bindValue(':alt_text', $data['alt_text'] ?? null);

        if ($is_featured !== null) {
            $stmt->bindValue(':is_featured', $is_featured, PDO::PARAM_BOOL);
        }

        return $stmt->execute();
    }

    /**
     * Delete image record
     * 
     * @param int $id Image ID
     * @return bool Success status
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Get image by ID
     * 
     * @param int $id Image ID
     * @return array|false Image data or false if not found
     */
    public function getById($id)
    {
        $sql = "SELECT i.*, u.full_name as user_name 
                FROM {$this->table} i 
                LEFT JOIN users u ON i.user_id = u.id 
                WHERE i.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get images by IDs
     * 
     * @param array $ids Array of image IDs
     * @return array List of images
     */
    public function getByIds($ids)
    {
        if (empty($ids)) {
            return [];
        }

        // Create placeholders for the IN clause
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM {$this->table} WHERE id IN ($placeholders)";

        $stmt = $this->db->prepare($sql);

        // Bind each ID as a separate parameter
        foreach ($ids as $index => $id) {
            $stmt->bindValue($index + 1, $id);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get featured images 
     * 
     * @param int $limit Maximum number of images to return
     * @return array List of featured images
     */
    public function getFeatured($limit = 10)
    {
        $sql = "SELECT * FROM {$this->table} 
                ORDER BY created_at DESC 
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Search images
     * 
     * @param string $keyword Search keyword
     * @param array $filters Additional filters
     * @return array Search results
     */
    public function search($keyword, $filters = [])
    {
        $sql = "SELECT i.*, u.full_name as user_name 
                FROM {$this->table} i 
                LEFT JOIN users u ON i.user_id = u.id 
                WHERE (i.title LIKE :keyword1 OR i.description LIKE :keyword2 OR i.alt_text LIKE :keyword3)";

        $keywordParam = "%$keyword%";

        // Add filters
        if (!empty($filters['user_id'])) {
            $sql .= " AND i.user_id = :user_id";
        }

        // Thêm điều kiện cho category
        if (!empty($filters['category'])) {
            $sql .= " AND i.category = :category";
        }

        // Thêm điều kiện cho status nếu cần
        if (isset($filters['status']) && $filters['status'] !== null) {
            $sql .= " AND i.status = :status";
        }

        $sql .= " ORDER BY i.created_at DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $this->db->prepare($sql);

        // Bind parameters with unique placeholders
        $stmt->bindValue(':keyword1', $keywordParam);
        $stmt->bindValue(':keyword2', $keywordParam);
        $stmt->bindValue(':keyword3', $keywordParam);

        if (!empty($filters['user_id'])) {
            $stmt->bindValue(':user_id', $filters['user_id']);
        }

        // Bind category nếu được cung cấp
        if (!empty($filters['category'])) {
            $stmt->bindValue(':category', $filters['category']);
        }

        // Bind status nếu được cung cấp và không null
        if (isset($filters['status']) && $filters['status'] !== null) {
            $stmt->bindValue(':status', $filters['status']);
        }

        if (!empty($filters['limit'])) {
            $stmt->bindValue(':limit', $filters['limit'], \PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get image statistics
     * 
     * @return array Image statistics
     */
    public function getStats()
    {
        $sql = "SELECT 
                COUNT(*) as total_images,
                COUNT(DISTINCT user_id) as total_users,
                SUM(file_size) as total_size
                FROM {$this->table}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    /**
     * Xóa bản ghi dựa trên một điều kiện cụ thể
     * 
     * @param string $column Tên cột
     * @param mixed $value Giá trị cần so sánh
     * @param string $operator Toán tử so sánh (=, >, <, ...)
     * @return bool Kết quả xóa
     */
    public function deleteWhere($column, $value, $operator = '=')
    {
        $sql = "DELETE FROM {$this->table} WHERE $column $operator :value";
        $stmt = $this->db->prepare($sql);

        $paramType = null;
        if (is_int($value)) {
            $paramType = \PDO::PARAM_INT;
        } elseif (is_bool($value)) {
            $paramType = \PDO::PARAM_BOOL;
        } elseif (is_null($value)) {
            $paramType = \PDO::PARAM_NULL;
        } else {
            $paramType = \PDO::PARAM_STR;
        }

        $stmt->bindValue(':value', $value, $paramType);

        return $stmt->execute();
    }
}
