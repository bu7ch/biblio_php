<?php

use PDO;

class Database {
    private static ?PDO $instance = null;
    public static function getConnection():PDO {
        if(self::$instance === null){
            
            try {

            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass =$_ENV['DB_PASS'] ?? '';
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            } catch (PDOException $e) {
            error_log("Erreur connexion DB: " . $e->getMessage());
            throw new \Exception("Erreur de connexion à la base de données");
            }
        }
        return self::$instance;
    }
}