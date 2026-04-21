<?php
namespace App\Controllers;
use App\Services\GameService;
use App\Models\Game;
use App\Models\Rating;

class GameController {
    
    public function index() {
        $category = $_GET['category'] ?? null;
        
        $gameService = new GameService();
        $games = $gameService->getCatalog($category);
        
        require_once __DIR__ . '/../../views/games/index.php';
    }

    public function show($id) {
        $gameModel = new Game();
        $ratingModel = new Rating();

        $game = $gameModel->getById($id);
        
        if (!$game) {
            http_response_code(404);
            die("Jeu introuvable.");
        }

        $reviews = $ratingModel->getByGameId($id);
        $averageRating = $ratingModel->getAverageScore($id);

        require_once __DIR__ . '/../../views/games/show.php';
    }

public function rate() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        $gameId = (int)$_POST['game_id'];
        $userId = $_SESSION['user_id'];
        $score = (int)$_POST['score'];
        $comment = trim($_POST['comment']);
        $ratingModel = new Rating();
        $success = $ratingModel->addRating($gameId, $userId, $score, $comment);
        if ($success) {
           header("Location: /games/" . $gameId . "?success=1");
         } else {
         header("Location: /games/" . $gameId . "?error=1");
         }
         exit();
          }
}

    
}