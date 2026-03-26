<?php

class Prompt {
    private $conn;
    private $table = "prompts";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($title, $content, $user_id, $category_id) {
        $stmt = $this->conn->prepare("
            INSERT INTO $this->table (title, content, user_id, category_id)
            VALUES (:title, :content, :user_id, :category_id)
        ");

        return $stmt->execute([
            'title' => $title,
            'content' => $content,
            'user_id' => $user_id,
            'category_id' => $category_id
        ]);
    }

    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT p.*, u.name AS author, c.name AS category
            FROM $this->table p
            INNER JOIN users u ON p.user_id = u.id
            INNER JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getByUser($user_id) {
    $query = "SELECT p.*, c.name AS category 
              FROM prompts p
              JOIN categories c ON p.category_id = c.id
              WHERE p.user_id = :user_id";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function update($id, $title, $content, $category_id) {
    $stmt = $this->conn->prepare("
        UPDATE $this->table 
        SET title = :title, 
            content = :content, 
            category_id = :category_id 
        WHERE id = :id
    ");

    return $stmt->execute([
        'id' => $id,
        'title' => $title,
        'content' => $content,
        'category_id' => $category_id
    ]);
}

public function getByCategory($category_id, $user_id = null) {
    $query = "SELECT p.*, c.name AS category, u.name AS author 
              FROM prompts p
              JOIN categories c ON p.category_id = c.id
              JOIN users u ON p.user_id = u.id
              WHERE p.category_id = :category_id"; 
    if ($user_id !== null) {
        $query .= " AND p.user_id = :user_id";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':category_id', $category_id);
    
    if ($user_id !== null) {
        $stmt->bindParam(':user_id', $user_id);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}