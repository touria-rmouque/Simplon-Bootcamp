<?php
namespace Models;

class Review {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getByRecipe($recipe_id) {
        $stmt = $this->db->prepare("SELECT r.*, u.username FROM reviews r 
                                    JOIN users u ON r.user_id = u.id 
                                    WHERE r.recipe_id = :recipe_id");
        $stmt->execute(['recipe_id' => $recipe_id]);
        return $stmt->fetchAll();
    }

    public function add($recipe_id, $user_id, $rating, $comment) {
        $stmt = $this->db->prepare("INSERT INTO reviews (recipe_id, user_id, rating, comment) 
                                    VALUES (:recipe_id, :user_id, :rating, :comment)");
        return $stmt->execute([
            'recipe_id' => $recipe_id,
            'user_id' => $user_id,
            'rating' => $rating,
            'comment' => $comment
        ]);
    }
}