<?php
namespace App\Entity; 

class Livre {
    private ?int $id=null;
    private string $titre;
    private string $auteur;
    private ?string $isbn = null;
    private ?string $description = null;
    private ?\DateTime $datePublication = null;

    public function __construct(string $titre, string $auteur, ?string $isbn, ?string $description, ?\DateTime $datePublication)
    {
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->isbn = $isbn;
        $this->description= $description;
        $this->datePublication= $datePublication;
    }
    // Getters
    public function getId(): ?int {return $this->id; }
    public function getTitre(): string {return $this->titre;}
    public function getAuteur(): string {return $this->auteur;}
    public function getIsbn(): string {return  $this->isbn;}
    public function getDescription(): string {return $this->description;}
    public function getDatePublication() : ?\DateTime {return $this->datePublication;}
    // Setters
    public function setId(int $id):void {$this->id = $id;}
    public function setTitre(string $titre):void {$this->titre = $titre;}
    public function setAuteur(string $auteur):void {$this->auteur = $auteur;}
    public function setIsbn(?string $isbn):void {$this->isbn = $isbn;}
    public function setDescription(?string $description):void {$this->description = $description;}
    public function setDatePublication(?\DateTime $date):void {$this->datePublication = $date;}


}