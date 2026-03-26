<?php
session_start();

require_once "../config/Database.php";
require_once "../models/Prompt.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit;
}

$db = (new Database())->connect();
$promptModel = new Prompt($db);

$redirectPage = ($_SESSION['role'] === 'admin') ? "admin_dashboard.php" : "developer_dashboard.php";

// CREATE
if (isset($_POST['create'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category_id'];
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content) && !empty($category_id)) {
        $promptModel->create($title, $content, $user_id, $category_id); 
        
        $_SESSION['flash_success'] = "Prompt ajouté avec succès !";
        header("Location: ../views/" . $redirectPage);
    } else {
        header("Location: ../views/" . $redirectPage . "?error=missing_fields");
    }
    exit;
}
// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    if ($promptModel->delete($id)) {
        $_SESSION['flash_success'] = "Prompt supprimé avec succès !";
        header("Location: ../views/" . $redirectPage);
    } else {
        header("Location: ../views/" . $redirectPage . "?error=delete_failed");
    }
    exit;
}
// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category_id'];

    if (!empty($id) && !empty($title) && !empty($content) && !empty($category_id)) {
        if ($promptModel->update($id, $title, $content, $category_id)) {
            $_SESSION['flash_success'] = "Prompt mis à jour avec succès !";
            header("Location: ../views/" . $redirectPage);
        } else {
            header("Location: ../views/" . $redirectPage . "?error=update_failed");
        }
    } else {
        header("Location: ../views/" . $redirectPage . "?error=missing_fields");
    }
    exit;
}
?>