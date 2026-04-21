<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Game {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM games ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE category = :category ORDER BY name ASC");
        $stmt->execute(['category' => $category]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO games (name, category, min_players, max_players, duration, description, difficulty) 
                VALUES (:name, :category, :min_players, :max_players, :duration, :description, :difficulty)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id; 
        $sql = "UPDATE games SET name=:name, category=:category, min_players=:min_players, 
                max_players=:max_players, duration=:duration, description=:description, difficulty=:difficulty 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM games WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function getAvailable() {
    $sql = "SELECT * FROM games WHERE is_available = 1 ORDER BY name ASC";
    return $this->db->query($sql)->fetchAll();
}
}