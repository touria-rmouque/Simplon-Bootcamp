<?php
require_once '../classes/Database.php';
$db = (new Database())->getConnection();

$user = 'touria';
$pass = password_hash("admin123", PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, password) VALUES (:u, :p) 
          ON DUPLICATE KEY UPDATE password = :p";
$stmt = $db->prepare($query);
$stmt->execute([':u' => $user, ':p' => $pass]);

echo "L'utilisateur 'touria' avec le mot de passe 'admin123' a été créé/mis à jour !";
?>