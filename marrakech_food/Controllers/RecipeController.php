<?php
namespace Controllers;

use Services\RecipeService;
use Services\CategoryService;
use Services\ReviewService;

class RecipeController {
    private $recipeService;
    private $categoryService;
    private $reviewService;

    public function __construct() {
        $this->recipeService = new RecipeService();
        $this->categoryService = new CategoryService();
        $this->reviewService = new ReviewService();
    }

    public function index() {
        $recipes = $this->recipeService->getLatestRecipes();
        $categories = $this->categoryService->getCategoriesList();
        
        require_once 'Views/recipes/index.php';
    }

    public function show($id) {
        $recipe = $this->recipeService->getRecipeDetails($id);
        
        if (!$recipe) {
            header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
            exit;
        }

        $reviews = $this->reviewService->getRecipeReviews($id);
        $averageRating = $this->reviewService->calculateAverageRating($id);

        require_once 'Views/recipes/show.php';
    }
    public function create() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /Simplon-Bootcamp/marrakech_food/login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $imageName = 'default_food.png';

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
            $targetDir = "assets/img/";
            $imageName = time() . '_' . basename($_FILES["image_file"]["name"]);
            $targetFilePath = $targetDir . $imageName;

            if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $targetFilePath)) {
                $imageName = 'default_food.png';
            }
        }
        $data['image_url'] = $imageName;

        if ($this->recipeService->createRecipe($data)) {
            header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
            exit;
        } else {
            $error = "Erreur lors de la création de la recette.";
            $categories = $this->categoryService->getCategoriesList();
            require_once 'Views/recipes/create.php';
        }
    } else {
        $categories = $this->categoryService->getCategoriesList();
        require_once 'Views/recipes/create.php';
    }
}

public function edit($id) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /Simplon-Bootcamp/marrakech_food/login');
        exit;
    }

    $recipe = $this->recipeService->getRecipeDetails($id);
    
    if (!$recipe || $recipe['user_id'] != $_SESSION['user_id']) {
        header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
        exit;
    }

    $categories = $this->categoryService->getCategoriesList();
    require_once 'Views/recipes/edit.php';
}

public function update() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $oldRecipe = $this->recipeService->getRecipeDetails($id);

        $data = [
            'titre' => $_POST['titre'],
            'description' => $_POST['description'],
            'category_id' => $_POST['category_id'],
            'image_url' => $oldRecipe['image_url'] 
        ];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $imageName = time() . '_' . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], "assets/img/" . $imageName)) {
                $data['image_url'] = $imageName;
            }
        }

        if ($this->recipeService->updateRecipe($id, $data)) {
            header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
        }
    }
}

public function delete($id) {
    $recipe = $this->recipeService->getRecipeDetails($id);
    
    if ($recipe && $recipe['user_id'] == $_SESSION['user_id']) {
        $this->recipeService->deleteRecipe($id);
    }
    
    header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
}
}