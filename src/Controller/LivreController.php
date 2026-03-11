<?php

use LivreRepository;

class LivreController {
    private LivreRepository $repository;


    public function __construct()
    {
        $this->repository = new LivreRepository();
    }

    public function index() {
        $livres = $this->repository->findAll();
        $this->render("livres/index", ['livres' => $livres]);
    
    }

    private function render(string $view, array $data = [], int $statusCode = 200){
        http_response_code($statusCode);
        extract($data);
        require_once __DIR__ . '/../View' . $view .'.php';
    }
    // TODO: add show() / create()
}