<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Reservation {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function create($data) {
    $sql = "INSERT INTO reservations (user_id, customer_name, phone, guests_count, reservation_date, reservation_time) 
            VALUES (:user_id, :customer_name, :phone, :guests_count, :reservation_date, :reservation_time)";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($data);
}

    public function getByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM reservations WHERE user_id = :user_id ORDER BY reservation_date DESC, reservation_time DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getByDate($date) {
        $sql = "SELECT r.*, u.username 
                FROM reservations r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.reservation_date = :date 
                ORDER BY r.reservation_time ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll();
    }

    public function getAllWithUsers() {
    $sql = "SELECT r.*, u.username 
            FROM reservations r 
            JOIN users u ON r.user_id = u.id 
            ORDER BY r.reservation_date DESC, r.reservation_time DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(); 
    return $stmt->fetchAll();
}
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE reservations SET status = :status WHERE id = :id");
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}