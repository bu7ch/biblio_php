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
}