<?php

namespace App\Models;

class Tour extends BaseModel
{
    protected $table = 'tours';

    public function __construct()
    {
        parent::__construct();
    }

    public function getTourDetails($tourId)
    {
        $sql = "SELECT tours.*, tour_categories.name as category_name, start_date, end_date 
        FROM tours
        JOIN tour_categories ON tours.category_id = tour_categories.id 
        JOIN tour_dates ON tour_dates.tour_id = tours.id 
        WHERE tours.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $tourId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}
