<?php

class Database {
    private $host = "127.0.0.1";
    private $db_name = "prompt_repo";
    private $username = "root";
    private $password = "";
    private $port = "3307"; 

    public function connect() {
        try {
            $conn = new PDO(
                "mysql:host=$this->host;port=$this->port;dbname=$this->db_name",
                $this->username,
                $this->password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;

        } catch(PDOException $e) {
            die("DB Error: " . $e->getMessage());
        }
    }
}