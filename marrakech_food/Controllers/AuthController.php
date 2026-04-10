<?php
namespace Controllers;

use Services\AuthService;

class AuthController {
    private $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            if ($username && $password) {
                $user = $this->authService->login($username, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    
                    header('Location: /Simplon-Bootcamp/marrakech_food/home');
                    exit;
                } else {
                    $error = "Identifiants incorrects";
                    require_once 'Views/auth/login.php';
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
                require_once 'Views/auth/login.php';
            }
        } else {
            require_once 'Views/auth/login.php';
        }
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            if ($username && $password) {
                if ($this->authService->register($username, $password)) {
                    header('Location: /Simplon-Bootcamp/marrakech_food/login');
                    exit;
                } else {
                    $error = "Erreur lors de l'inscription (pseudo peut-être déjà pris)";
                    require_once 'Views/auth/register.php';
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
                require_once 'Views/auth/register.php';
            }
        } else {
            require_once 'Views/auth/register.php';
        }
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        header('Location: /Simplon-Bootcamp/marrakech_food/login');
        exit;
    }
}