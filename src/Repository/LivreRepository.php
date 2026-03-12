<?php
namespace App\Repository;

use App\Model\Database;
use App\Entity\Livre;
use PDO;

class LivreRepository {
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->pdo;
    }

    public function find(int $id): ?Livre 
    {
        $stmt = $this->pdo->prepare('SELECT * FROM livres WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);  // Ajouter FETCH_ASSOC ici aussi
        return $row ? $this->hydrate($row) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM livres ORDER BY id DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $livres = [];
        foreach ($rows as $row) {
            $livres[] = $this->hydrate($row);
        }
        return $livres;
    }

    private function hydrate(array $data): Livre {
        $livre = new Livre(
            $data['titre'],
            $data['auteur'],
            $data['isbn'] ?? null,
            $data['description'] ?? null,
            $data['date_publication'] ? new \DateTime($data['date_publication']) : null,
        );
        $livre->setId((int) $data['id']); 
        return $livre;
    }
}