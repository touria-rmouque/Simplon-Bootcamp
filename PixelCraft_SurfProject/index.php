<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/Database/Database.php';
require_once __DIR__ . '/Models/User.php';
require_once __DIR__ . '/Models/Student.php';
require_once __DIR__ . '/Models/Admin.php';
require_once __DIR__ . '/Controllers/AuthController.php';
require_once __DIR__ . '/Controllers/AdminController.php';

$database = new Database();
$db = $database->connect();

$page = $_GET['page'] ?? 'login';

switch ($page) {
    
    //AUTHENTIFICATION
    case 'login':
        require_once __DIR__ . '/Views/auth/login.php';
        break;

    case 'register':
        require_once __DIR__ . '/Views/auth/register.php';
        break;

    case 'logout':
        $auth = new AuthController($db);
        $auth->logout();
        break;

    // DASHBOARD ÉTUDIANT
    case 'student_dashboard':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header("Location: index.php?page=login");
            exit();
        }
        $studentModel = new Student($db);
        $profile = $studentModel->getProfile($_SESSION['user_id']);
        $schedule = $studentModel->getMySchedule($_SESSION['user_id']);
        require_once __DIR__ . '/Views/student/dashboard.php';
        break;

    //ZONE ADMINISTRATION 
    case 'admin_dashboard':
    case 'add_lesson':
    case 'edit_lesson':
    case 'manage_enrollments':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?page=login");
            exit();
        }

        $adminController = new AdminController();
        $adminModel = new Admin($db);
        $studentModel = new Student($db);

        // TRAITEMENT DES ACTIONS (POST/GET) 
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'updateLevel':
                    $adminController->updateLevel();
                    exit();
                case 'createLesson':
                    $adminController->createLesson();
                    exit();
                case 'enrollStudent':
                    $adminController->enrollStudent(); 
                    exit();
                case 'cancelEnrollment':
                    $adminController->cancelEnrollment();
                    exit();
                case 'updateFullStudent':
                    $adminController->updateFullStudent(); 
                    exit();
                case 'updatePayment':
                     $adminController->updatePayment(); 
                    exit();
                case 'updateLesson':
                  $adminController->updateLesson();
                  exit();

                  case 'softDelete':
                   $adminController->archiveLesson();
                   exit();
            }
        }

       // AFFICHAGE DES VUES ADMIN 
        if ($page === 'add_lesson') {
            require_once __DIR__ . '/Views/admin/add_lesson.php';
        } 
        elseif ($page === 'edit_lesson') { 
        $lesson_id = $_GET['id'] ?? null;
        if ($lesson_id) {
            $lesson = $adminModel->getLessonById($lesson_id);
            require_once __DIR__ . '/Views/admin/edit_lesson.php';
        } else {
            header("Location: index.php?page=admin_dashboard");
        }
        }
        elseif ($page === 'manage_enrollments') {
            $lesson_id = $_GET['id'] ?? null;
            if ($lesson_id) {
                $lesson = $adminModel->getLessonById($lesson_id); 
                $enrolled_students = $adminModel->getStudentsInLesson($lesson_id); 
                $available_students = $studentModel->getAllStudents(); 
                
                require_once __DIR__ . '/Views/admin/manage_enrollments.php';
            } else {
                header("Location: index.php?page=admin_dashboard");
            }
        } 
        else {
            $lessons = $adminModel->getAllActiveLessons(); 
            $all_students = $studentModel->getAllStudents();
            require_once __DIR__ . '/Views/admin/dashboard.php';
        }
        break;

    default:
        http_response_code(404);
        echo "<div style='text-align:center; margin-top:50px; font-family: sans-serif;'>";
        echo "<h1 style='color: #0A2540;'>🌊 Oups ! Cette vague n'existe pas.</h1>";
        echo "<p>La page que vous cherchez est introuvable.</p>";
        echo "<a href='index.php?page=login' style='color: #19C3B1; font-weight: bold;'>Retour à l'accueil</a>";
        echo "</div>";
        break;
}