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
        if ($category->create($name)) {
            $_SESSION['flash_success'] = "created";
        } else {
            $_SESSION['flash_error'] = "db_error";
        }
    } else {
        $_SESSION['flash_error'] = "missing_fields";
    }
    header("Location: ../views/admin_dashboard.php");
    exit;
}

// DELETE
if (isset($_GET['delete_category'])) {
    $id = $_GET['delete_category'];
    
    if ($category->delete($id)) {
        $_SESSION['flash_success'] = "deleted";
    } else {
        $_SESSION['flash_error'] = "delete_failed";
    }
    header("Location: ../views/admin_dashboard.php");
    exit;
}

// UPDATE
if (isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    
    if (!empty($id) && !empty($name)) {
        if ($category->update($id, $name)) {
            $_SESSION['flash_success'] = "updated";
        } else {
            $_SESSION['flash_error'] = "update_failed";
        }
    } else {
        $_SESSION['flash_error'] = "missing_fields";
    }
    header("Location: ../views/admin_dashboard.php");
    exit;
}
?>