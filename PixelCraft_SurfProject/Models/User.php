<?php

class User {
    protected $conn;
    protected $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE email = :email 
                  AND deleted_at IS NULL 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $password) {
        $user = $this->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function delete($id) {
    $query = "UPDATE " . $this->table . " 
              SET deleted_at = NOW() 
              WHERE id = :id";
    
    try {
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        return false;
    }
}
}
?>