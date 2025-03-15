<?php
namespace App\Models;

class Tour extends BaseModel {
    protected $table = 'tours';
    
    public function __construct() {
        parent::__construct();
    }

    public function getTourDetails($tourId) {
        $sql = "SELECT * FROM tours WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $tourId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    
  }

?>