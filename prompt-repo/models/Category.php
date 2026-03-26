<?php

class Category {
    private $conn;
    private $table = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($name) {
        $query = "INSERT INTO $this->table (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            'name' => $name
        ]);
    }

    public function getAll() {
        $query = "SELECT * FROM $this->table ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name) {
        $query = "UPDATE $this->table 
                  SET name = :name 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            'id' => $id,
            'name' => $name
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function getTopCategories() {
        $query = "SELECT c.name, COUNT(p.id) as total_prompts
                  FROM categories c
                  LEFT JOIN prompts p ON c.id = p.category_id
                  GROUP BY c.id
                  ORDER BY total_prompts DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}