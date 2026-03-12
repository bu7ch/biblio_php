<?php
declare(strict_types=1);

namespace App\Controller;

use LivreRepository;


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
        $this->render('livre/index', ['livres' => $livres]);
    }

    public function show(int $id): void
    {
        $livre = $this->repo->find($id);
        if (!$livre) {
            throw new \Exception("Livre introuvable");
        }
        $this->render('livre/show', ['livre' => $livre]);
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