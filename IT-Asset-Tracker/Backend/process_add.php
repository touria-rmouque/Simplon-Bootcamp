<?php
require_once '../classes/Database.php';
require_once '../classes/Asset.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $asset = new Asset(
        $db, 
        $_POST['serial_number'], 
        $_POST['device_name'], 
        $_POST['price'], 
        $_POST['status'], 
        $_POST['category_id']
    );

    if ($asset->create()) {
        
        header("Location: ../Frontend/inventory.php?msg=success");
    } else {
        echo "Erreur lors de l'ajout du matériel.";
    }
}
?>