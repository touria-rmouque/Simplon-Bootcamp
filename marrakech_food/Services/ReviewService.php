<?php
namespace Services;

use Models\Review;

class ReviewService {
    private $reviewModel;

    public function __construct() {
        $this->reviewModel = new Review();
    }

    public function getRecipeReviews($recipeId) {
        return $this->reviewModel->getByRecipe($recipeId);
    }

   public function calculateAverageRating($recipeId) {
    $reviews = $this->getRecipeReviews($recipeId); 
    if (empty($reviews)) return 0;

    $total = 0;
    foreach ($reviews as $review) {
        $total += $review['rating'];
    }
    return round($total / count($reviews), 1);
}

    public function postReview($recipeId, $userId, $rating, $comment) {
        if ($rating < 1 || $rating > 5) return false;
        
        return $this->reviewModel->add($recipeId, $userId, $rating, $comment);
    }
}