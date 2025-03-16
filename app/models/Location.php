<?php

namespace App\Models;

class Location extends BaseModel {
    protected $table = 'locations';
    
    public function getBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function getPopular($limit = 6) {
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
    
    public function getByRegion($region, $limit = null) {
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
    
    public function getByCountry($country, $limit = null) {
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
    
    public function updateStatus($id, $status) {
        return $this->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function generateSlug($name, $excludeId = null) {
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
}