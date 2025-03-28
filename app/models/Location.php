<?php

namespace App\Models;

class Location extends BaseModel
{
    protected $table = 'locations';

    public function getBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getPopular($limit = 6)
    {
        $sql = "
            SELECT 
                l.*,
                COUNT(t.id) as tour_count,
                l.image as image_url  -- Sử dụng trực tiếp cột image có sẵn
            FROM 
                {$this->table} l
            LEFT JOIN 
                tours t ON l.id = t.location_id AND t.status = 'active'
            WHERE 
                l.status = 'active'
            GROUP BY 
                l.id
            ORDER BY 
                tour_count DESC, l.name ASC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByRegion($region, $limit = null)
    {
        $sql = "
            SELECT 
                l.*,
                COUNT(t.id) as tour_count
            FROM 
                {$this->table} l
            LEFT JOIN 
                tours t ON l.id = t.location_id AND t.status = 'active'
            WHERE 
                l.region = :region AND l.status = 'active'
            GROUP BY 
                l.id
            ORDER BY 
                tour_count DESC, l.name ASC
        ";

        if ($limit) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':region', $region);

        if ($limit) {
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByCountry($country, $limit = null)
    {
        $sql = "
            SELECT 
                l.*,
                COUNT(t.id) as tour_count
            FROM 
                {$this->table} l
            LEFT JOIN 
                tours t ON l.id = t.location_id AND t.status = 'active'
            WHERE 
                l.country = :country AND l.status = 'active'
            GROUP BY 
                l.id
            ORDER BY 
                tour_count DESC, l.name ASC
        ";

        if ($limit) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':country', $country);

        if ($limit) {
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        return $this->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function generateSlug($name, $excludeId = null)
    {
        // Convert to lowercase and replace spaces with hyphens
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));

        // Check if slug already exists
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE slug = :slug";
        $params = [':slug' => $slug];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params[':id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        // If slug exists, append a number
        if ($result['count'] > 0) {
            $i = 1;
            $originalSlug = $slug;

            do {
                $slug = $originalSlug . '-' . $i;
                $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE slug = :slug";
                $params = [':slug' => $slug];

                if ($excludeId) {
                    $sql .= " AND id != :id";
                    $params[':id'] = $excludeId;
                }

                $stmt = $this->db->prepare($sql);

                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value);
                }

                $stmt->execute();
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                $i++;
            } while ($result['count'] > 0);
        }

        return $slug;
    }

    /**
     * Get paginated locations with optional filters
     * 
     * @param int $page Page number
     * @param int $limit Items per page
     * @param array $filters Optional filters
     * @return array Paginated locations with pagination metadata
     */
    public function getPaginated($page = 1, $limit = 10, $filters = [])
    {
        $offset = ($page - 1) * $limit;

        // Build the base query
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active'";
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'active'";
        $params = [];
        $countParams = [];

        // Apply filter for region
        if (!empty($filters['region'])) {
            $sql .= " AND region = :region";
            $countSql .= " AND region = :region";
            $params[':region'] = $filters['region'];
            $countParams[':region'] = $filters['region'];
        }

        // Apply filter for country
        if (!empty($filters['country'])) {
            $sql .= " AND country = :country";
            $countSql .= " AND country = :country";
            $params[':country'] = $filters['country'];
            $countParams[':country'] = $filters['country'];
        }

        // Add sorting and pagination
        $sql .= " ORDER BY name ASC LIMIT :limit OFFSET :offset";
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
     * Get distinct regions for filtering purposes
     * 
     * @return array Array of distinct region names
     */
    public function getDistinctRegions()
    {
        $sql = "SELECT DISTINCT region FROM {$this->table} WHERE status = 'active' ORDER BY region ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Get countries from a specific region for filtering purposes
     * 
     * @param string $region Region name to filter countries by
     * @return array Array of country names in the specified region
     */
    public function getCountriesByRegion($region)
    {
        $sql = "SELECT DISTINCT country FROM {$this->table} WHERE region = :region AND status = 'active' ORDER BY country ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':region', $region);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function findBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: false;
    }
}
