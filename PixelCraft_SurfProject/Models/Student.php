<?php

require_once __DIR__ . '/User.php';

class Student extends User {
    private $studentTable = "students";

    public function __construct($db) {
        parent::__construct($db);
    }

    public function register($fullName, $email, $password, $country, $level) {
        try {
            $this->conn->beginTransaction();

            $queryUser = "INSERT INTO " . $this->table . " (email, password, role) 
                          VALUES (:email, :password, 'student')";
            
            $stmtUser = $this->conn->prepare($queryUser);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmtUser->execute([
                ':email'    => $email,
                ':password' => $hashedPassword
            ]);

            $userId = $this->conn->lastInsertId();

            $queryStudent = "INSERT INTO " . $this->studentTable . " (id_user, full_name, country, level) 
                             VALUES (:id_user, :full_name, :country, :level)";
            
            $stmtStudent = $this->conn->prepare($queryStudent);
            $stmtStudent->execute([
                ':id_user'   => $userId,
                ':full_name' => $fullName,
                ':country'   => $country,
                ':level'     => $level
            ]);

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getMySchedule($userId) {
    $query = "SELECT l.*, e.payment_status 
              FROM lessons l
              JOIN enrollments e ON l.id = e.id_lesson
              WHERE e.id_student = :userId
              ORDER BY l.lesson_date ASC";
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute([':userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getProfile($userId) {
        $query = "SELECT u.email, u.role, s.full_name, s.country, s.level 
                  FROM " . $this->table . " u 
                  JOIN " . $this->studentTable . " s ON u.id = s.id_user 
                  WHERE u.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $userId]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllStudents() {
    $query = "SELECT u.id, u.email, s.full_name, s.country, s.level 
              FROM " . $this->table . " u 
              JOIN " . $this->studentTable . " s ON u.id = s.id_user 
              WHERE u.role = 'student' 
              AND u.deleted_at IS NULL"; 
              
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}