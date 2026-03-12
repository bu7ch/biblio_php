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
        $row = $stmt->fetch(PDO::FETCH_ASSOC);  
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
    /**
 * Insère un nouveau livre en base de données.
 *
 * @param Livre $livre L'objet Livre à sauvegarder (sans ID).
 * @return bool True si l'insertion a réussi, false sinon.
 * @throws \InvalidArgumentException Si le livre a déjà un ID (utilisez update() à la place).
 */
public function save(Livre $livre): bool
{
    // Vérifier que le livre n'a pas déjà d'ID (sinon, c'est une mise à jour)
    if ($livre->getId() !== null) {
        throw new \InvalidArgumentException(
            "Un livre avec un ID existant ne peut pas être sauvegardé avec save(). Utilisez update() à la place."
        );
    }

    // Préparer la requête d'insertion (les colonnes doivent correspondre à votre table)
    $query = $this->pdo->prepare("
        INSERT INTO livres (titre, auteur, isbn, description, date_publication)
        VALUES (:titre, :auteur, :isbn, :description, :date_publication)
    ");

    // Exécuter avec les données de l'objet
    $result = $query->execute([
        ':titre'            => $livre->getTitre(),
        ':auteur'           => $livre->getAuteur(),
        ':isbn'             => $livre->getIsbn(),
        ':description'      => $livre->getDescription(),
        ':date_publication' => $livre->getDatePublication()?->format('Y-m-d') // nullsafe operator PHP 8
    ]);

    // Si l'insertion a réussi, récupérer l'ID généré et l'affecter à l'objet
    if ($result) {
        $livre->setId((int)$this->pdo->lastInsertId());
    }

    return $result;
}
/**
 * Met à jour un livre existant.
 *
 * @param Livre $livre L'objet Livre à mettre à jour (doit avoir un ID).
 * @return bool True si la mise à jour a réussi, false sinon.
 * @throws \InvalidArgumentException Si le livre n'a pas d'ID.
 */
public function update(Livre $livre): bool
{
    if (!$livre->getId()) {
        throw new \InvalidArgumentException(
            "Impossible de mettre à jour un livre sans ID."
        );
    }

    $query = $this->pdo->prepare("
        UPDATE livres
        SET titre = :titre,
            auteur = :auteur,
            isbn = :isbn,
            description = :description,
            date_publication = :date_publication
        WHERE id = :id
    ");

    return $query->execute([
        ':id'               => $livre->getId(),
        ':titre'            => $livre->getTitre(),
        ':auteur'           => $livre->getAuteur(),
        ':isbn'             => $livre->getIsbn(),
        ':description'      => $livre->getDescription(),
        ':date_publication' => $livre->getDatePublication()?->format('Y-m-d')
    ]);
}
 public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM livres WHERE id = ?");
        return $stmt->execute([$id]);
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