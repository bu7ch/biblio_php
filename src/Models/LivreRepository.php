<?php

use Livre;
use PDO;

class LivreRepository {
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function find(int $id): ?Livre {
        $query = $this->db->prepare("
        SELECT * FROM livres WHERE id= :id
        ");
        $query->execute([':id'=> $id]);
        $data = $query->fetch();
        return $data ? $this->hydrate($data) : null ;
    }
    public function findAll():array {
        $query = $this->db->query("
        SELECT * FROM livres ORDER BY id DESC
        ");
        $livres = [];
        while ($data = $query->fetch()){
            $livres[]= $this->hydrate($data);
        }
        return $livres;
    }

    TODO: add save() / update() / delete()

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