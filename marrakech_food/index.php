<?php
session_start();

// Autoloader
spl_autoload_register(function ($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

// Récupération et nettoyage de l'URL
$url = (isset($_GET['url'])) ? rtrim($_GET['url'], '/') : 'login';
$url = str_replace(['.html', '.php'], '', $url);

// --- AUTHENTIFICATION ---
if ($url === 'login') {
    $controller = new \Controllers\AuthController();
    $controller->login();
} 
elseif ($url === 'register') {
    $controller = new \Controllers\AuthController();
    $controller->register();
} 
elseif ($url === 'logout') {
    $controller = new \Controllers\AuthController();
    $controller->logout();
}

// --- GESTION DES RECETTES (HOME / CATALOGUE) ---
elseif ($url === 'recipes' || $url === 'home') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /Simplon-Bootcamp/marrakech_food/login');
        exit;
    }
    $controller = new \Controllers\RecipeController();
    $controller->index();
} 

// --- DÉTAILS D'UNE RECETTE ---
elseif ($url === 'recipe/show') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    if ($id) {
        $controller = new \Controllers\RecipeController();
        $controller->show($id);
    } else {
        header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
        exit;
    }
} 

// --- AJOUT DE RECETTE ---
elseif ($url === 'recipe/add') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /Simplon-Bootcamp/marrakech_food/login');
        exit;
    }
    $controller = new \Controllers\RecipeController();
    $controller->create();
}

// --- AJOUT D'UN AVIS (MODIFICATION ICI) ---
elseif ($url === 'review/add') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /Simplon-Bootcamp/marrakech_food/login');
        exit;
    }
    $controller = new \Controllers\ReviewController();
    $controller->add();
}
// --- MODIFICATION DE RECETTE ---
elseif ($url === 'recipe/edit') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    if ($id) {
        $controller = new \Controllers\RecipeController();
        $controller->edit($id);
    } else {
        header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
        exit;
    }
} 

// --- TRAITEMENT DE LA MISE À JOUR ---
elseif ($url === 'recipe/update') {
    $controller = new \Controllers\RecipeController();
    $controller->update();
}

// --- SUPPRESSION DE RECETTE ---
elseif ($url === 'recipe/delete') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    if ($id) {
        $controller = new \Controllers\RecipeController();
        $controller->delete($id);
    } else {
        header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
        exit;
    }
}

// --- GESTION DES FAVORIS ---
elseif ($url === 'favorite/toggle') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /Simplon-Bootcamp/marrakech_food/login');
        exit;
    }

    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    if ($id) {
        $controller = new \Controllers\FavoriteController();
        $controller->toggle($id);
    } else {
        header('Location: /Simplon-Bootcamp/marrakech_food/recipes');
        exit;
    }
}

// --- ERREUR 404 ---
else {
    http_response_code(404);
    echo "<style>
            body { background: #0a1118; color: #d4af37; font-family: 'Segoe UI', sans-serif; 
                   display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column; }
            h1 { font-size: 80px; margin: 0; }
            p { color: #64748b; margin-bottom: 20px; }
            a { color: #d4af37; text-decoration: none; border: 1px solid #d4af37; padding: 10px 20px; border-radius: 5px; }
            a:hover { background: #d4af37; color: #0a1118; }
          </style>";
    echo "<h1>404</h1>";
    echo "<p>Le plat [ " . htmlspecialchars($url) . " ] n'existe pas dans notre carte.</p>";
    echo "<a href='/Simplon-Bootcamp/marrakech_food/recipes'>Retour à la cuisine</a>";
}