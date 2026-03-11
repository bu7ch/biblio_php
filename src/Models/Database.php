<?php

use PDO;

class Database {
    private static ?PDO $instance = null;
    public function getConnection():PDO {
        if(self::$instance === null){
            try {
            $host = Environment::get('DB_HOST');
            $dbname = Environment::get('DB_NAME');
            $user = Environment::get('DB_USER');
            $pass =Environment::get('DB_PASS');
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            } catch (PDOException $e) {
            error_log("Erreur connexion DB: " . $e->getMessage());
            throw new \Exception("Erreur de connexion à la base de données");
            }
        }
        return self::$instance;
    }
}