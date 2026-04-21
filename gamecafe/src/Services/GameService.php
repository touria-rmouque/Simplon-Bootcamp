<?php
namespace App\Services;
use App\Models\Game;
use App\Models\Rating;

class GameService {
    private $gameModel;
    private $ratingModel;

    public function __construct() {
        $this->gameModel = new Game();
        $this->ratingModel = new Rating();
    }

    public function getCatalog($categoryFilter = null) {
        if ($categoryFilter) {
            $games = $this->gameModel->getByCategory($categoryFilter);
        } else {
            $games = $this->gameModel->getAll();
        }

        foreach ($games as &$game) {
            $game['average_rating'] = $this->ratingModel->getAverageScore($game['id']);
        }

        return $games;
    }


    public function getRecommendations($guestsCount) {
        $allGames = $this->gameModel->getAll();
        $recommendations = [];

        foreach ($allGames as $game) {
            if ($guestsCount >= $game['min_players'] && $guestsCount <= $game['max_players']) {
                $recommendations[] = $game;
            }
        }

        return $recommendations;
    }
}