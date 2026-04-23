<?php
namespace App\Models;
use App\Core\Database;
use PDO;
use Exception;

class Session {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function startSession($data) {
        try {
            $this->db->beginTransaction();
            $sql = "INSERT INTO sessions (reservation_id, game_id, table_id, start_time) 
                    VALUES (:reservation_id, :game_id, :table_id, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            $stmtTable = $this->db->prepare("UPDATE game_tables SET is_occupied = 1 WHERE id = :table_id");
            $stmtTable->execute(['table_id' => $data['table_id']]);
            $stmtGame = $this->db->prepare("UPDATE games SET is_available = 0 WHERE id = :game_id");
            $stmtGame->execute(['game_id' => $data['game_id']]);

            return $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function endSession($sessionId) {
        try {
            $this->db->beginTransaction();
            $stmtInfo = $this->db->prepare("SELECT game_id, table_id FROM sessions WHERE id = :id");
            $stmtInfo->execute(['id' => $sessionId]);
            $session = $stmtInfo->fetch();

            if ($session) {
                $stmtEnd = $this->db->prepare("UPDATE sessions SET end_time = NOW() WHERE id = :id");
                $stmtEnd->execute(['id' => $sessionId]);

                $stmtTable = $this->db->prepare("UPDATE game_tables SET is_occupied = 0 WHERE id = :table_id");
                $stmtTable->execute(['table_id' => $session['table_id']]);

                $stmtGame = $this->db->prepare("UPDATE games SET is_available = 1 WHERE id = :game_id");
                $stmtGame->execute(['game_id' => $session['game_id']]);
            }

            return $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getActiveSessions() {
        $sql = "SELECT s.*, g.name AS game_name, t.name AS table_name, 
                       u.username AS client_name,
                       TIMESTAMPDIFF(MINUTE, s.start_time, NOW()) as total_minutes 
                FROM sessions s
                JOIN games g ON s.game_id = g.id
                JOIN game_tables t ON s.table_id = t.id
                LEFT JOIN reservations r ON s.reservation_id = r.id
                LEFT JOIN users u ON r.user_id = u.id
                WHERE s.end_time IS NULL
                ORDER BY s.start_time ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getHistory() {
        $sql = "SELECT s.*, g.name AS game_name, t.name AS table_name, 
                       u.username AS client_name,
                       TIMEDIFF(s.end_time, s.start_time) as duration_formatted
                FROM sessions s
                JOIN games g ON s.game_id = g.id
                JOIN game_tables t ON s.table_id = t.id
                LEFT JOIN reservations r ON s.reservation_id = r.id
                LEFT JOIN users u ON r.user_id = u.id
                WHERE s.end_time IS NOT NULL
                ORDER BY s.end_time DESC";
        return $this->db->query($sql)->fetchAll();
    }
}