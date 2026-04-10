<?php
namespace Services;

use Models\Recipe;

class RecipeService {
    private $recipeModel;

    public function __construct() {
        $this->recipeModel = new Recipe();
    }

    public function getLatestRecipes() {
        return $this->recipeModel->getAll();
    }

    public function getRecipeDetails($id) {
        $recipe = $this->recipeModel->findById($id);
        if (!$recipe) {
            return null;
        }
        return $recipe;
    }

   public function createRecipe($data) {
    $userId = $_SESSION['user_id'] ?? null;

    if (empty($data['title']) || empty($data['category_id']) || !$userId) {
        return false;
    }

    return $this->recipeModel->create(
        $data['title'],
        $data['description'] ?? '',
        $data['ingredients'] ?? '',
        $data['instructions'] ?? '',
        $data['image_url'], 
        $data['category_id'],
        $userId
    );
}

    public function updateRecipe($id, $data) {
        if (empty($data['titre'])) {
            return false;
        }
        return $this->recipeModel->update($id, $data);
    }

    public function deleteRecipe($id) {
        return $this->recipeModel->delete($id);
    }
}