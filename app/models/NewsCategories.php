<?php

namespace App\Models;

use PDO;

class NewsCategories extends BaseModel
{
    protected $table = 'news_categories';

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
        $updated_at
    ) {

        $sql = "INSERT INTO news_categories(name, slug, description, image, status, created_at, updated_at)
            VALUES(:name, :slug, :description, :image, :status, :created_at, :updated_at)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':updated_at', $updated_at);

        $stmt->execute();
    }

    public function updateCategory(
        $id,
        $name,
        $slug,
        $description,
        $image,
        $status
    ) {
        $updated_at = date('Y-m-d H:i:s');

        $sql = "UPDATE news_categories 
            SET name = :name, 
                slug = :slug, 
                description = :description, 
                image = :image,
                status = :status,
                updated_at = :updated_at
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':updated_at', $updated_at);

        return $stmt->execute();
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
}
