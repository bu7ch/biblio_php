<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\LivreRepository;  

class LivreController
{
    private LivreRepository $repo;

    public function __construct()
    {
        $this->repo = new LivreRepository();
    }

    public function index(): void
    {
        $livres = $this->repo->findAll();
        $this->render('livres/index', ['livres' => $livres]);
    }

    /**
     * Affiche les détails d'un livre spécifique
     * @param int $id L'ID du livre à afficher
     */
    public function show(int $id)
    {
        // 1. Récupérer le livre via le Repository
        $livre = $this->repo->find($id);

        // 2. Gérer le cas où le livre n'existe pas (erreur 404)
        if (!$livre) {
            // On peut appeler une méthode dédiée ou une vue d'erreur
            $this->render('erreurs/404', ['message' => 'Livre non trouvé'], 404);
            return;
        }

        // 3. Afficher la vue de détail en passant l'objet Livre
        $this->render('livres/show', ['livre' => $livre]);
    }


    private function render(string $view, array $data = []): void
    {
        extract($data);
        ob_start();
        require __DIR__ . '/../View/' . $view . '.php';  
        
        $content = ob_get_clean();
        require __DIR__ . '/../View/layout.php';         
    }
}