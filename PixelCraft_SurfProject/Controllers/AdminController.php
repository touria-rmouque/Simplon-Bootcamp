<?php
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Student.php';
require_once __DIR__ . '/../Models/Admin.php'; 

class AdminController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();

        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?page=login");
            exit();
        }
    }

    public function enrollStudent() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lessonId = $_POST['lesson_id'] ?? null;
        $studentId = $_POST['student_id'] ?? null; 

        if ($lessonId && $studentId) {
            $adminModel = new Admin($this->db);
            if ($adminModel->enrollById($lessonId, $studentId)) {
                header("Location: index.php?page=manage_enrollments&id=" . $lessonId . "&success=enrolled");
            } else {
                header("Location: index.php?page=manage_enrollments&id=" . $lessonId . "&error=failed");
            }
            exit();
        }
    }
}

    public function cancelEnrollment() {
        $lessonId = $_GET['lesson_id'] ?? null;
        $studentId = $_GET['student_id'] ?? null;

        if ($lessonId && $studentId) {
            $adminModel = new Admin($this->db);
            if ($adminModel->removeStudentFromLesson($lessonId, $studentId)) {
                header("Location: index.php?page=manage_enrollments&id=" . $lessonId . "&success=removed");
            } else {
                header("Location: index.php?page=manage_enrollments&id=" . $lessonId . "&error=remove_failed");
            }
            exit();
        }
    }

    public function listStudents() {
        $studentModel = new Student($this->db);
        $students = $studentModel->getAllStudents();
        require_once __DIR__ . '/../Views/admin/students_list.php';
    }

    public function createLesson() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'title' => $_POST['title'] ?? '',
            'coach_name' => $_POST['coach_name'] ?? '',
            'lesson_date' => $_POST['lesson_date'] ?? '',
            'max_students' => $_POST['max_students'] ?? 8,
            'price' => $_POST['price'] ?? 0 
        ];

        $adminModel = new Admin($this->db);
        if ($adminModel->addLesson($data)) {
            header("Location: index.php?page=admin_dashboard&success=lesson_added");
        } else {
            header("Location: index.php?page=admin_dashboard&error=failed");
        }
        exit();
    }
}

    public function updateLevel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentId = $_POST['student_id'] ?? null;
            $newLevel = $_POST['new_level'] ?? null;

            if ($studentId && $newLevel) {
                $adminModel = new Admin($this->db);
                if ($adminModel->updateStudentLevel($studentId, $newLevel)) {
                    header("Location: index.php?page=admin_dashboard&success=level_updated");
                    exit();
                }
            }
            header("Location: index.php?page=admin_dashboard&error=update_failed");
            exit();
        }
    }

    public function updateFullStudent() {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $adminModel = new Admin($this->db);
        
        $id      = $_POST['student_id'] ?? null;
        $name    = $_POST['full_name'] ?? '';
        $email   = $_POST['email'] ?? '';
        $country = $_POST['country'] ?? '';
        $level   = $_POST['level'] ?? 'Beginner';
        $payment = $_POST['payment_status'] ?? 'Pending';

        if ($id) {
            $success = $adminModel->updateStudentFull($id, $name, $email, $country, $level);
            
            if ($success) {
                header("Location: index.php?page=admin_dashboard&status=updated");
            } else {
                header("Location: index.php?page=admin_dashboard&status=error");
            }
        } else {
            header("Location: index.php?page=admin_dashboard&status=missing_id");
        }
        exit();
    }
}

public function updatePayment() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lessonId = $_POST['lesson_id'] ?? null;
        $studentId = $_POST['student_id'] ?? null;
        $status = $_POST['payment_status'] ?? 'Pending';

        if ($lessonId && $studentId) {
            $adminModel = new Admin($this->db);
            if ($adminModel->updateEnrollmentPayment($lessonId, $studentId, $status)) {
                header("Location: index.php?page=manage_enrollments&id=" . $lessonId . "&success=payment_updated");
            } else {
                header("Location: index.php?page=manage_enrollments&id=" . $lessonId . "&error=payment_failed");
            }
            exit();
        }
    }
}
public function updateLesson() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['lesson_id'];
        $title = $_POST['title'];
        $date = $_POST['lesson_date'];
        $max = $_POST['max_students'];
        $coach = $_POST['coach_name'];
        $price = $_POST['price'] ?? 0; 

        $adminModel = new Admin($this->db);
        
        $adminModel->updateLesson($id, $title, $coach, $date, $max, $price); 

        header("Location: index.php?page=admin_dashboard&status=updated");
        exit();
    }
}
public function archiveLesson() {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $adminModel = new Admin($this->db);
        $adminModel->softDeleteLesson($id);
    }
    header("Location: index.php?page=admin_dashboard&status=archived");
    exit();
}
}