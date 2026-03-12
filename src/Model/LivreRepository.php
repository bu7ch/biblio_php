<?php

use App\Model\Database;
use Livre;
use PDO;

class LivreRepository {
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->pdo;    }

    public function find(int $id): ?Livre 
    {
        $stmt = $this->pdo->prepare('SELECT * FROM livres WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->hydrate($row) : null;
    }
    public function findAll():array
    {
        $stmt = $this->pdo->query('SELECT * FROM livres ORDER BY id DESC');
        return $stmt->fetchAll(\PDO::FETCH_FUNC, [$this, 'hydrate']);
    }

   // TODO:  add save() / update() / delete()

    private function hydrate(array $data): Livre {
        $livre = new Livre(
            $data['titre'],
            $data['auteur'],
            $data['isbn'] ?? null,
            $data['description'] ?? null,
            $data['date_publication'] ? new \DateTime($data['date_publication']) : null,
        );
        $livre->setId($data['id']);
        return $livre;
    }

}