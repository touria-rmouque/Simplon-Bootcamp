<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Rating {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addRating($gameId, $userId, $score, $comment) {
    $sql = "INSERT INTO ratings (game_id, user_id, score, comment, created_at) 
            VALUES (:game_id, :user_id, :score, :comment, NOW())";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        'game_id' => $gameId,
        'user_id' => $userId,
        'score' => $score,
        'comment' => $comment
    ]);
}

    public function getByGameId($gameId) {
        $sql = "SELECT r.*, u.username 
                FROM ratings r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.game_id = :game_id 
                ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['game_id' => $gameId]);
        return $stmt->fetchAll();
    }

    public function getAverageScore($gameId) {
        $stmt = $this->db->prepare("SELECT AVG(score) as average FROM ratings WHERE game_id = :game_id");
        $stmt->execute(['game_id' => $gameId]);
        $result = $stmt->fetch();
        return $result['average'] ? round($result['average'], 1) : null;
    }
}