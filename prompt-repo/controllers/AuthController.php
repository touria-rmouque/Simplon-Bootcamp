<?php
session_start();

require_once "../config/Database.php";
require_once "../models/User.php";

$db = (new Database())->connect();
$user = new User($db);

// LOGIN
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: ../views/login.php?error=empty_fields");
        exit;
    }

    $result = $user->login($email, $password);

    if ($result) {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_name'] = $result['name'];
        $_SESSION['role'] = $result['role'];

        if ($_SESSION['role'] === 'admin') {
            header("Location: ../views/admin_dashboard.php");
        } else {
            header("Location: ../views/developer_dashboard.php");
        }
        exit;
    } else {
        header("Location: ../views/login.php?error=1");
        exit;
    }
}

// REGISTER
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; 

    $result = $user->register($name, $email, $password);

    if ($result) {
        
        header("Location: ../views/login.php?success=registered");
    } else {
        header("Location: ../views/register.php?error=email_exists");
    }
    exit;
}

// LOGOUT
if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: ../views/login.php");
    exit;
}
?>