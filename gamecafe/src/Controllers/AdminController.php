<?php
namespace App\Controllers;
use App\Services\AuthService;
use App\Services\SessionService;
use App\Models\Game;
use App\Models\Reservation;
use App\Models\Session;
use App\Models\Table;

class AdminController {
    
    public function __construct() {
        AuthService::requireAdmin();
    }
    public function dashboard() {
    $sessionService = new SessionService();
    $sessionModel = new Session();
    $activeSessions = $sessionService->getActiveSessionsWithTimer();
    $historySessions = $sessionModel->getHistory(); 
    require_once __DIR__ . '/../../views/admin/dashboard.php';
}

    public function reservations() {
    $reservationModel = new Reservation();
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $status = $_GET['action'] === 'confirm' ? 'confirmée' : 'annulée';
        $reservationModel->updateStatus($_GET['id'], $status);
        $filter = $_GET['filter'] ?? 'all';
        header("Location: /admin/reservations?filter=" . $filter);
        exit();
    }
    $filter = $_GET['filter'] ?? 'all';

    if ($filter === 'today') {
        $reservations = $reservationModel->getByDate(date('Y-m-d'));
    } else {
        $reservations = $reservationModel->getAllWithUsers();
    }
    
    require_once __DIR__ . '/../../views/admin/reservations.php';
}

    public function startSession() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sessionModel = new Session();
        $sessionModel->startSession([
            'reservation_id' => $_POST['reservation_id'] ?: null,
            'game_id' => $_POST['game_id'],
            'table_id' => $_POST['table_id']
        ]);
        header('Location: /admin/dashboard');
        exit();
    }

    $gameModel = new Game();
    $tableModel = new Table();
    $reservationModel = new Reservation();
    $games = $gameModel->getAvailable(); 
    $tables = $tableModel->getFree();
    $reservations = $reservationModel->getByDate(date('Y-m-d')); 

    require_once __DIR__ . '/../../views/admin/session_start.php';
}

    public function endSession($id) {
        $sessionModel = new Session();
        $sessionModel->endSession($id);
        header('Location: /admin/dashboard');
        exit();
    }

    
    public function manageGames() {
    $gameModel = new Game();
    $games = $gameModel->getAll();
    require_once __DIR__ . '/../../views/admin/games_manage.php';
     }

    public function createGame() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gameModel = new Game();
            $data = [
                'name' => $_POST['name'],
                'category' => $_POST['category'],
                'min_players' => $_POST['min_players'],
                'max_players' => $_POST['max_players'],
                'duration' => $_POST['duration'],
                'description' => $_POST['description'],
                'difficulty' => $_POST['difficulty']
            ];
            
            if ($gameModel->create($data)) {
                header('Location: /admin/games?success=added');
                exit();
            }
        }
        require_once __DIR__ . '/../../views/admin/game_form.php';
    }


public function editGame() {
    $gameModel = new Game();
    $id = $_GET['id'] ?? null;
    
    if (!$id) { header('Location: /admin/games'); exit(); }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($gameModel->update($id, $_POST)) {
            header('Location: /admin/games?success=updated');
            exit();
        }
    }

    $game = $gameModel->getById($id); 
    $pageTitle = "Modifier : " . $game['name'];
    require_once __DIR__ . '/../../views/admin/game_form.php';
}

    public function deleteGame() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $gameModel = new Game();
            $gameModel->delete($_POST['id']);
            header('Location: /admin/games?success=deleted');
            exit();
        }
    }
}