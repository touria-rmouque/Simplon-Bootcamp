<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Initialisation du Routeur
use App\Core\Router;
$router = new Router();

// --- Pages Publiques ---
$router->add('GET', '/', 'App\Controllers\GameController', 'index');
$router->add('GET', '/games', 'App\Controllers\GameController', 'index');
$router->add('GET', '/games/{id}', 'App\Controllers\GameController', 'show');
$router->add('POST', '/games/rate', 'App\Controllers\GameController', 'rate');

// --- Authentification ---
$router->add('GET', '/login', 'App\Controllers\AuthController', 'login');
$router->add('POST', '/login', 'App\Controllers\AuthController', 'login');
$router->add('GET', '/logout', 'App\Controllers\AuthController', 'logout');
$router->add('GET', '/register', 'App\Controllers\AuthController', 'register');
$router->add('POST', '/register', 'App\Controllers\AuthController', 'register');

// --- Espace Client (Réservations) ---
$router->add('GET', '/reservations/create', 'App\Controllers\ReservationController', 'create');
$router->add('POST', '/reservations/create', 'App\Controllers\ReservationController', 'create');
$router->add('GET', '/reservations/history', 'App\Controllers\ReservationController', 'history');

// --- Espace Administrateur ---
$router->add('GET', '/admin/dashboard', 'App\Controllers\AdminController', 'dashboard');
$router->add('GET', '/admin/reservations', 'App\Controllers\AdminController', 'reservations');
$router->add('GET', '/admin/sessions/start', 'App\Controllers\AdminController', 'startSession');
$router->add('POST', '/admin/sessions/start', 'App\Controllers\AdminController', 'startSession');
$router->add('POST', '/admin/sessions/{id}/end', 'App\Controllers\AdminController', 'endSession');

// --- Gestion du catalogue ---
$router->add('GET', '/admin/games', 'App\Controllers\AdminController', 'manageGames');
$router->add('GET', '/admin/games/create', 'App\Controllers\AdminController', 'createGame');
$router->add('POST', '/admin/games/create', 'App\Controllers\AdminController', 'createGame');
$router->add('GET', '/admin/games/edit', 'App\Controllers\AdminController', 'editGame');
$router->add('POST', '/admin/games/edit', 'App\Controllers\AdminController', 'editGame');
$router->add('POST', '/admin/games/delete', 'App\Controllers\AdminController', 'deleteGame');

//EXÉCUTION DE LA REQUÊTE
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// lance la route 
$router->dispatch($uri, $method);