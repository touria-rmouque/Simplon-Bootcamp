<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    private function __construct() {}

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                $host = 'localhost';
                $port = 3307; 
                $dbname = 'gamecafe_db';
                $username = 'root';
                $password = ''; 

                self::$instance = new PDO(
                    "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false 
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        
        return self::$instance;
    }
}