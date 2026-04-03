<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Student.php';

class AuthController {
    private $db;

    public function __construct($db = null) {
        if ($db) {
            $this->db = $db;
        } else {
            $database = new Database();
            $this->db = $database->connect();
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = $_POST['fullName'];
            $email    = $_POST['email'];
            $password = $_POST['password'];
            $country  = $_POST['country'];
            $level    = $_POST['level'];

            $student = new Student($this->db);
            
            if ($student->register($fullName, $email, $password, $country, $level)) {
                header("Location: ../index.php?page=login&success=account_created");
            } else {
                header("Location: ../index.php?page=register&error=registration_failed");
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User($this->db);
            $user = $userModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_role']  = $user['role'];
                $_SESSION['user_email'] = $user['email'];

                if ($user['role'] === 'admin') {
                    header("Location: ../index.php?page=admin_dashboard");
                } else {
                    header("Location: ../index.php?page=student_dashboard");
                }
            } else {
                header("Location: ../index.php?page=login&error=invalid_credentials");
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../index.php?page=login");
    }
}

$controller = new AuthController();
$action = $_GET['action'] ?? '';

if ($action === 'register') {
    $controller->register();
} elseif ($action === 'login') {
    $controller->login();
} elseif ($action === 'logout') {
    $controller->logout();
}