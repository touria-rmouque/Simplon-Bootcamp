<?php

require_once __DIR__ . '/User.php';

class Admin extends User {
    private $lessonTable = "lessons";

    public function __construct($db) {
        parent::__construct($db);
    }

    public function addLesson($data) {
    $query = "INSERT INTO " . $this->lessonTable . " (title, coach_name, lesson_date, max_students, price) 
              VALUES (:title, :coach, :date, :max, :price)";
    
    $stmt = $this->conn->prepare($query); 
    
    return $stmt->execute([
        ':title' => $data['title'],
        ':coach' => $data['coach_name'],
        ':date'  => $data['lesson_date'],
        ':max'   => $data['max_students'],
        ':price' => $data['price'] 
    ]);
}

public function updateLesson($id, $title, $coach_name, $lesson_date, $max_students, $price) {
    $query = "UPDATE " . $this->lessonTable . " 
              SET title = :title, 
                  coach_name = :coach_name, 
                  lesson_date = :lesson_date, 
                  max_students = :max_students,
                  price = :price 
              WHERE id = :id";
    
    $stmt = $this->conn->prepare($query);
    
    return $stmt->execute([
        ':id'           => $id,
        ':title'        => $title,
        ':coach_name'   => $coach_name,
        ':lesson_date'  => $lesson_date,
        ':max_students' => $max_students,
        ':price'        => $price 
    ]);
}

    public function softDeleteLesson($id) {
        $query = "UPDATE " . $this->lessonTable . " 
                  SET deleted_at = NOW() 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function getLessonStudents($lessonId) {
        $query = "SELECT s.full_name, s.level, e.payment_status 
                  FROM students s
                  JOIN enrollments e ON s.id_user = e.id_student
                  WHERE e.id_lesson = :id_lesson";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id_lesson' => $lessonId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDeletedStudents() {
        $query = "SELECT u.id, u.email, s.full_name, u.deleted_at 
                  FROM users u 
                  JOIN students s ON u.id = s.id_user 
                  WHERE u.deleted_at IS NOT NULL";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActiveLessons() {
    $query = "SELECT l.*, COUNT(e.id_student) as current_students 
              FROM " . $this->lessonTable . " l
              LEFT JOIN enrollments e ON l.id = e.id_lesson
              WHERE l.deleted_at IS NULL 
              GROUP BY l.id
              ORDER BY l.lesson_date ASC";
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function updateStudentLevel($id, $level) {
        $sql = "UPDATE students SET level = :level WHERE id_user = :id";
        
        $stmt = $this->conn->prepare($sql); 
        return $stmt->execute([':level' => $level, ':id' => $id]);
    }

    public function removeStudentFromLesson($lessonId, $studentId) {
        $query = "DELETE FROM enrollments WHERE id_lesson = :id_lesson AND id_student = :id_student";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id_lesson'  => $lessonId,
            ':id_student' => $studentId
        ]);
    }
    public function getLessonById($id) {
        $query = "SELECT * FROM " . $this->lessonTable . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function getStudentsInLesson($lessonId) {
    $query = "SELECT s.id_user as student_id, s.full_name, s.level, u.email, e.payment_status 
              FROM students s
              JOIN users u ON s.id_user = u.id
              JOIN enrollments e ON s.id_user = e.id_student
              WHERE e.id_lesson = :id_lesson";
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute([':id_lesson' => $lessonId]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

   public function enrollById($lessonId, $studentId) {
    $checkQuery = "SELECT id_student FROM enrollments WHERE id_lesson = :id_l AND id_student = :id_s";
    $checkStmt = $this->conn->prepare($checkQuery);
    $checkStmt->execute([':id_l' => $lessonId, ':id_s' => $studentId]);
    
    if ($checkStmt->fetch()) {
        return false; 
    }
    $lesson = $this->getLessonById($lessonId);
    $queryCount = "SELECT COUNT(*) as total FROM enrollments WHERE id_lesson = :id_l";
    $stmtCount = $this->conn->prepare($queryCount);
    $stmtCount->execute([':id_l' => $lessonId]);
    $count = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];

    if ($count >= $lesson['max_students']) {
        return false; 
    }

    $query = "INSERT INTO enrollments (id_student, id_lesson) 
              VALUES (:id_student, :id_lesson)";
    $stmt = $this->conn->prepare($query);
    
    return $stmt->execute([
        ':id_student' => $studentId,
        ':id_lesson'  => $lessonId
    ]);
}

public function updateEnrollmentPayment($lessonId, $studentId, $paymentStatus) {
    $query = "UPDATE enrollments 
              SET payment_status = :status 
              WHERE id_lesson = :id_l AND id_student = :id_s";
    
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([
        ':status' => $paymentStatus,
        ':id_l'   => $lessonId,
        ':id_s'   => $studentId
    ]);
}

public function updateStudentFull($id, $name, $email, $country, $level) {
    try {
        $queryProfile = "UPDATE users u
                         JOIN students s ON u.id = s.id_user 
                         SET s.full_name = :name, u.email = :email, s.country = :country, s.level = :level
                         WHERE u.id = :id";
                         
        $stmtProfile = $this->conn->prepare($queryProfile);
        return $stmtProfile->execute([
            ':name'    => $name,
            ':email'   => $email,
            ':country' => $country,
            ':level'   => $level,
            ':id'      => $id
        ]);
    } catch (PDOException $e) { return false; }
}

    public function deleteStudent($id) {
        $query = "UPDATE users SET deleted_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function deleteLesson($id) {
        return $this->softDeleteLesson($id);
    }

    public function getAllActiveStudents() {
        $query = "SELECT u.id, u.email, s.full_name, s.country, s.level, 
                  (SELECT payment_status FROM enrollments WHERE id_student = u.id ORDER BY id DESC LIMIT 1) as payment_status
                  FROM users u
                  JOIN students s ON u.id = s.id_user
                  WHERE u.deleted_at IS NULL AND u.role = 'student'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}