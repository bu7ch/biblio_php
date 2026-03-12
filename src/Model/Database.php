<?php
namespace App\Model;

use PDO;
use PDOException;

class Database
{
    public PDO $pdo;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? 'db';
        $db   = $_ENV['DB_NAME'] ?? 'bibliotheque';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? 'secret';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException("❌ Connexion impossible : " . $e->getMessage());
        }
    }

    public function query(string $sql): \PDOStatement
    {
        return $this->pdo->query($sql);
    }
}