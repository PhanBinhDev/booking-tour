<?php

namespace App\Models;

class PaymentMethod extends BaseModel
{

    protected $table = 'payment_methods';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Tìm bản ghi theo ID
     * 
     * @param int $id ID của bản ghi cần tìm
     * @return array|false Thông tin bản ghi hoặc false nếu không tìm thấy
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get all active payment methods
     * 
     * @return array List of active payment methods
     */
    public function getAllActive()
    {
        return $this->getAll("*", ['is_active' => 1]);
    }

    /**
     * Create a new payment method
     * 
     * @param array $data Payment method data
     * @return int|bool The ID of the new payment method or false on failure
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (name, code, description, logo, instructions, is_active, config, created_at) 
                VALUES (:name, :code, :description, :logo, :instructions, :is_active, :config, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':code', $data['code']);
        $stmt->bindValue(':description', $data['description'] ?? '');
        $stmt->bindValue(':logo', $data['logo'] ?? null);
        $stmt->bindValue(':instructions', $data['instructions'] ?? '');
        $stmt->bindValue(':is_active', $data['is_active'] ?? 1);
        $stmt->bindValue(':config', $data['config'] ?? '{}');

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }


    /**
     * Toggle payment method status
     * 
     * @param int $id Payment method ID
     * @param int $status New status (0 or 1)
     * @return bool Result of the operation
     */
    public function toggleStatus($id, $status)
    {
        return $this->update($id, ['is_active' => $status]);
    }

    /**
     * Get payment method by code
     * 
     * @param string $code Payment method code
     * @return array|false Payment method data or false if not found
     */
    public function getByCode($code)
    {
        $sql = "SELECT * FROM {$this->table} WHERE code = :code";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
