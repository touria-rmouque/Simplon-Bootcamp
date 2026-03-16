<?php
require_once '../classes/Database.php';
require_once '../classes/Asset.php';

if (isset($_GET['sn'])) {
    $database = new Database();
    $db = $database->getConnection();

    $asset = new Asset($db, $_GET['sn']);

    if ($asset->delete()) {
        header("Location: ../Frontend/inventory.php?msg=deleted");
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    header("Location: ../Frontend/inventory.php");
}
?>