<?php
namespace App\Services;
use App\Models\User;

class AuthService {
    
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function attemptLogin($username, $password) {
        self::startSession();
        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false; 
    }
    public function register($username, $email, $password) {
        $userModel = new User();
        
        if ($userModel->findByUsername($username)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $userModel->create(
            $username, 
            $hashedPassword, 
            'client'
        );
    }

    public static function logout() {
        self::startSession();
        session_unset();
        session_destroy();
    }

    public static function isAdmin() {
        self::startSession();
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: /login?error=acces_refuse');
            exit(); 
        }
    }

    public static function requireLogin() {
        self::startSession();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=veuillez_vous_connecter');
            exit(); 
        }
    }
}