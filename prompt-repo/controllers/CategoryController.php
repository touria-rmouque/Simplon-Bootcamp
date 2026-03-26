<?php
session_start();

require_once "../config/Database.php";
require_once "../models/Category.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/login.php");
    exit;
}

$db = (new Database())->connect();
$category = new Category($db);

// CREATE
if (isset($_POST['create_category'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $category->create($name);
        header("Location: ../views/admin_dashboard.php?success=created"); 
        exit;
    } else {
        header("Location: ../views/admin_dashboard.php?error=missing_fields");
        exit;
    }
}

// DELETE
if (isset($_GET['delete_category'])) {
    $id = $_GET['delete_category'];
    if ($category->delete($id)) {
        header("Location: ../views/admin_dashboard.php?success=deleted");
    } else {
        header("Location: ../views/admin_dashboard.php?error=delete_failed");
    }
    exit;
}

// UPDATE
if (isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    if (!empty($id) && !empty($name)) {
        if ($category->update($id, $name)) {
            header("Location: ../views/admin_dashboard.php?success=updated");
        } else {
            header("Location: ../views/admin_dashboard.php?error=update_failed");
        }
    } else {
        header("Location: ../views/admin_dashboard.php?error=missing_fields");
    }
    exit;
}
?>