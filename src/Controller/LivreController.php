<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;

class LivreController
{
    private LivreRepository $repo;

    public function __construct()
    {
        $this->repo = new LivreRepository();
    }

    /**
     * Affiche la liste de tous les livres.
     */
    public function index(): void
    {
        $livres = $this->repo->findAll();
        $this->render('livres/index', ['livres' => $livres]);
    }

    /**
     * Affiche les détails d'un livre spécifique.
     *
     * @param int $id L'identifiant du livre.
     */
    public function show(int $id): void
    {
        $livre = $this->repo->find($id);
        if (!$livre) {
            $this->render('erreurs/404', ['message' => 'Livre non trouvé'], 404);
            return;
        }
        $this->render('livres/show', ['livre' => $livre]);
    }

    /**
     * Affiche le formulaire de création d'un livre.
     */
    public function create(): void
    {
        $this->render('livres/create');
    }

    /**
     * Traite la soumission du formulaire de création.
     */
    public function store(): void
    {
        // Vérifier que la requête est bien en POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /livres/create');
            exit;
        }

        // Récupération et nettoyage des données
        $titre = trim($_POST['titre'] ?? '');
        $auteur = trim($_POST['auteur'] ?? '');
        $isbn = trim($_POST['isbn'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $datePublication = !empty($_POST['date_publication']) ? $_POST['date_publication'] : null;

        // Validation
        $errors = [];
        if (empty($titre)) {
            $errors[] = 'Le titre est obligatoire.';
        }
        if (empty($auteur)) {
            $errors[] = 'L\'auteur est obligatoire.';
        }
        if ($datePublication && !\DateTime::createFromFormat('Y-m-d', $datePublication)) {
            $errors[] = 'Le format de la date est invalide (utilisez AAAA-MM-JJ).';
        }

        if (!empty($errors)) {
            $this->render('livres/create', [
                'errors' => $errors,
                'old'    => $_POST
            ]);
            return;
        }

        // Création de l'objet Livre
        $livre = new Livre(
            titre: $titre,
            auteur: $auteur,
            isbn: $isbn ?: null,
            description: $description ?: null,
            datePublication: $datePublication ? new \DateTime($datePublication) : null
        );

        // Sauvegarde
        if ($this->repo->save($livre)) {
            // Redirection vers la liste avec un message de succès (optionnel)
            header('Location: /livres?success=1');
            exit;
        } else {
            $this->render('livres/create', [
                'errors' => ['Erreur lors de l\'enregistrement en base de données.'],
                'old'    => $_POST
            ]);
        }
    }

    /**
     * Affiche le formulaire d'édition d'un livre.
     *
     * @param int $id L'identifiant du livre à modifier.
     */
    public function edit(int $id): void
    {
        $livre = $this->repo->find($id);
        if (!$livre) {
            $this->render('erreurs/404', ['message' => 'Livre non trouvé'], 404);
            return;
        }
        $this->render('livres/edit', ['livre' => $livre]);
    }

    /**
     * Traite la soumission du formulaire d'édition.
     *
     * @param int $id L'identifiant du livre à mettre à jour.
     */
    public function update(int $id): void
    {
        // Vérifier la méthode HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /livres/edit/$id");
            exit;
        }

        // Récupérer le livre existant
        $livre = $this->repo->find($id);
        if (!$livre) {
            $this->render('erreurs/404', ['message' => 'Livre non trouvé'], 404);
            return;
        }

        // Mettre à jour les propriétés avec les données POST
        $titre = trim($_POST['titre'] ?? '');
        $auteur = trim($_POST['auteur'] ?? '');
        $isbn = trim($_POST['isbn'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $datePublication = !empty($_POST['date_publication']) ? $_POST['date_publication'] : null;

        // Validation
        $errors = [];
        if (empty($titre)) {
            $errors[] = 'Le titre est obligatoire.';
        }
        if (empty($auteur)) {
            $errors[] = 'L\'auteur est obligatoire.';
        }
        if ($datePublication && !\DateTime::createFromFormat('Y-m-d', $datePublication)) {
            $errors[] = 'Le format de la date est invalide (utilisez AAAA-MM-JJ).';
        }

        if (!empty($errors)) {
            $this->render('livres/edit', [
                'errors' => $errors,
                'livre'  => $livre, // pour pré-remplir avec les anciennes valeurs
                'old'    => $_POST
            ]);
            return;
        }

        // Modifier l'objet
        $livre->setTitre($titre);
        $livre->setAuteur($auteur);
        $livre->setIsbn($isbn ?: null);
        $livre->setDescription($description ?: null);
        $livre->setDatePublication($datePublication ? new \DateTime($datePublication) : null);

        // Sauvegarder les modifications
        if ($this->repo->update($livre)) {
            header('Location: /livres?updated=1');
            exit;
        } else {
            $this->render('livres/edit', [
                'errors' => ['Erreur lors de la mise à jour.'],
                'livre'  => $livre
            ]);
        }
    }

    // /**
    //  * Supprime un livre.
    //  *
    //  * @param int $id L'identifiant du livre à supprimer.
    //  */
    // public function delete(int $id): void
    // {
    //     // Vérifier que le livre existe
    //     $livre = $this->repo->find($id);
    //     if (!$livre) {
    //         $this->render('erreurs/404', ['message' => 'Livre non trouvé'], 404);
    //         return;
    //     }

    //     // Effectuer la suppression
    //     if ($this->repo->delete($id)) {
    //         header('Location: /livres?deleted=1');
    //         exit;
    //     } else {
    //         // En cas d'erreur, on peut rediriger avec un message d'erreur
    //         header('Location: /livres?error=1');
    //         exit;
    //     }
    // }

    /**
     * Méthode utilitaire pour afficher une vue.
     *
     * @param string $view       Chemin de la vue (relatif à src/View/).
     * @param array  $data       Données à extraire pour la vue.
     * @param int    $statusCode Code HTTP de la réponse.
     */
    private function render(string $view, array $data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        extract($data);
        ob_start();
        require_once __DIR__ . '/../View/' . $view . '.php';
        $content = ob_get_clean();
        require __DIR__ . '/../View/layout.php';
    }
}
