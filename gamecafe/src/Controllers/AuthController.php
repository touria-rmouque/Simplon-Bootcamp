<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Models\User; 

class AuthController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $authService = new AuthService();
            if ($authService->attemptLogin($username, $password)) {
                if (AuthService::isAdmin()) {
                    header('Location: /admin/dashboard');
                } else {
                    header('Location: /games');
                }
                exit();
            } else {
                $error = "Identifiants incorrects.";
            }
        }

        require_once __DIR__ . '/../../views/auth/login.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $authService = new AuthService();
            if ($authService->register($username, $email, $password)) {
                header('Location: /login?success=compte_cree');
                exit();
            } else {
                $error = "Erreur lors de l'inscription. L'utilisateur existe peut-être déjà.";
            }
        }

        require_once __DIR__ . '/../../views/auth/register.php';
    }

    public function logout() {
        AuthService::logout();
        header('Location: /login?message=deconnecte');
        exit();
    }
}