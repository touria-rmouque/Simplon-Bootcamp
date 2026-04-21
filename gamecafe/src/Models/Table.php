<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Table {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM game_tables");
        return $stmt->fetchAll();
    }

    public function getTablesByCapacity($minCapacity): array { 
        $stmt = $this->db->prepare("SELECT * FROM game_tables WHERE capacity >= :capacity ORDER BY capacity ASC");
        $stmt->execute(['capacity' => $minCapacity]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results ? $results : []; 
    }

    public function getFree() {
    $sql = "SELECT * FROM game_tables WHERE is_occupied = 0 ORDER BY name ASC";
    return $this->db->query($sql)->fetchAll();
}
}