<?php
namespace Models;

class Recipe {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
    $userId = $_SESSION['user_id'] ?? 0;
    $sql = "
        SELECT r.*, c.nom as category_name,
        (SELECT COUNT(*) FROM favorites f WHERE f.recipe_id = r.id AND f.user_id = :userId) as is_favorite
        FROM recipes r 
        LEFT JOIN categories c ON r.category_id = c.id 
        WHERE r.deleted_at IS NULL 
        ORDER BY r.created_at DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetchAll();
}

   public function findById($id) {
    $stmt = $this->db->prepare("
        SELECT r.*, c.nom as category_name 
        FROM recipes r 
        LEFT JOIN categories c ON r.category_id = c.id 
        WHERE r.id = :id AND r.deleted_at IS NULL
    ");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}
    public function create($titre, $description, $ingredients, $instructions, $image_url, $category_id, $user_id) {
    $sql = "INSERT INTO recipes (titre, description, ingredients, instructions, image_url, category_id, user_id) 
            VALUES (:titre, :description, :ingredients, :instructions, :image_url, :category_id, :user_id)";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        'titre' => $titre,
        'description' => $description,
        'ingredients' => $ingredients,
        'instructions' => $instructions,
        'image_url' => $image_url,
        'category_id' => $category_id,
        'user_id' => $user_id
    ]);
}

public function update($id, $data) {
    $sql = "UPDATE recipes SET 
            titre = :titre, 
            description = :description, 
            category_id = :category_id, 
            image_url = :image_url 
            WHERE id = :id";
    
    $stmt = $this->db->prepare($sql);
    $data['id'] = $id;
    return $stmt->execute($data);
}

public function delete($id) {
    $stmt = $this->db->prepare("UPDATE recipes SET deleted_at = NOW() WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}
}