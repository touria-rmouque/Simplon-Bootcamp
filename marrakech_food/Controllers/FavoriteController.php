<?php
namespace Controllers;

use Models\Database;

class FavoriteController {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function toggle($recipe_id) {
        $user_id = $_SESSION['user_id'];

        $check = $this->db->prepare("SELECT id FROM favorites WHERE user_id = :u AND recipe_id = :r");
        $check->execute(['u' => $user_id, 'r' => $recipe_id]);
        $favorite = $check->fetch();

        if ($favorite) {
            $stmt = $this->db->prepare("DELETE FROM favorites WHERE id = :id");
            $stmt->execute(['id' => $favorite['id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (:u, :r)");
            $stmt->execute(['u' => $user_id, 'r' => $recipe_id]);
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}