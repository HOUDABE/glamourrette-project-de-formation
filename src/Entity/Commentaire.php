<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titreCommentaire;

    #[ORM\Column(type: 'string', length: 255)]
    private $descCommentaire;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'commentaireR')]
    private $produit;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commentaireR')]
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreCommentaire(): ?string
    {
        return $this->titreCommentaire;
    }

    public function setTitreCommentaire(string $titreCommentaire): self
    {
        $this->titreCommentaire = $titreCommentaire;

        return $this;
    }

    public function getDescCommentaire(): ?string
    {
        return $this->descCommentaire;
    }

    public function setDescCommentaire(string $descCommentaire): self
    {
        $this->descCommentaire = $descCommentaire;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
