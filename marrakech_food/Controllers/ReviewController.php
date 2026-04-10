<?php
namespace Controllers;

use Services\ReviewService;

class ReviewController {
    private $reviewService;

    public function __construct() {
        $this->reviewService = new ReviewService();
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $recipeId = $_POST['recipe_id'];
            $userId = $_SESSION['user_id'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];

            $this->reviewService->postReview($recipeId, $userId, $rating, $comment);
            
            header("Location: /Simplon-Bootcamp/marrakech_food/recipe/show?id=" . $recipeId);
            exit;
        }
    }
}