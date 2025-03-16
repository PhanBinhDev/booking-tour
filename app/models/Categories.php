<?php

namespace App\Models;

use PDO;

class Categories extends BaseModel
{
    protected $table = 'tour_categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function createCategory(
        $name,
        $slug,
        $description,
        $image,
        $status,
        $created_at,
        $updated_at,
    ) {
        $sql = "INSERT INTO news(name, slug, description, image, status, created_at,
                                updated_at)
                VALUES('$name', '$slug', '$description', '$image',
                        '$status', '$created_at', '$updated_at')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function getCategory($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}
