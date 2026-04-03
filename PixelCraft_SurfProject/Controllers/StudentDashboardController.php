<?php
session_start();
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Models/Student.php';

class StudentDashboardController {
    private $db;
    private $studentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->studentModel = new Student($this->db);
        
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header("Location: ../auth/login.php");
            exit();
        }
    }

    public function index() {
        $studentId = $_SESSION['user_id'];
        $profile = $this->studentModel->getProfile($studentId);
        require_once __DIR__ . '/../Views/student/dashboard.php';
    }
}