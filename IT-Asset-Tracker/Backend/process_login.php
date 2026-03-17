<?php
session_start();
require_once '../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = (new Database())->getConnection();
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $user);
    $stmt->execute();
    $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($foundUser && password_verify($pass, $foundUser['password'])) {
        $_SESSION['user_id'] = $foundUser['id'];
        $_SESSION['username'] = $foundUser['username'];
        header('Location: ../Frontend/index.php'); 
        exit();
    } else {
        header('Location: ../Frontend/login.php?error=1');
        exit();
    }
}