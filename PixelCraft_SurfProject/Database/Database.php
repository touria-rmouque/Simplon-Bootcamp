<?php

class Database {
    private $host = "127.0.0.1";
    private $db_name = "taghazout_surf_db";
    private $username = "root";
    private $password = "";
    private $port = "3307"; 

    public function connect() {
        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            
            $conn = new PDO($dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conn;
        } catch(PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}