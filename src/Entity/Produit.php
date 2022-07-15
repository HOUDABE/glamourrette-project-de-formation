<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $imageProduit;

    #[ORM\Column(type: 'string', length: 255)]
    private $titreProduit;

    #[ORM\Column(type: 'string', length: 1255)]
    private $descProduit;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    public $prixProduit;

    #[ORM\Column(type: 'date')]
    private $dateArrive;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: CommandeOneLine::class)]
    private $commandeOneLineR;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    private $categorieR;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Commentaire::class)]
    private $commentaireR;

    public function __construct()
    {
        $this->commandeOneLineR = new ArrayCollection();
        $this->commentaireR = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageProduit(): ?string
    {
        return $this->imageProduit;
    }

    public function setImageProduit(string $imageProduit): self
    {
        $this->imageProduit = $imageProduit;

        return $this;
    }

    public function getTitreProduit(): ?string
    {
        return $this->titreProduit;
    }

    public function setTitreProduit(string $titreProduit): self
    {
        $this->titreProduit = $titreProduit;

        return $this;
    }

    public function getDescProduit(): ?string
    {
        return $this->descProduit;
    }

    public function setDescProduit(string $descProduit): self
    {
        $this->descProduit = $descProduit;

        return $this;
    }

    public function getPrixProduit(): ?string
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(string $prixProduit): self
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->dateArrive;
    }

    public function setDateArrive(\DateTimeInterface $dateArrive): self
    {
        $this->dateArrive = $dateArrive;

        return $this;
    }

    /**
     * @return Collection<int, CommandeOneLine>
     */
    public function getCommandeOneLineR(): Collection
    {
        return $this->commandeOneLineR;
    }

    public function addCommandeOneLineR(CommandeOneLine $commandeOneLineR): self
    {
        if (!$this->commandeOneLineR->contains($commandeOneLineR)) {
            $this->commandeOneLineR[] = $commandeOneLineR;
            $commandeOneLineR->setProduit($this);
        }

        return $this;
    }

    public function removeCommandeOneLineR(CommandeOneLine $commandeOneLineR): self
    {
        if ($this->commandeOneLineR->removeElement($commandeOneLineR)) {
            // set the owning side to null (unless already changed)
            if ($commandeOneLineR->getProduit() === $this) {
                $commandeOneLineR->setProduit(null);
            }
        }

        return $this;
    }

    public function getCategorieR(): ?Categorie
    {
        return $this->categorieR;
    }

    public function setCategorieR(?Categorie $categorieR): self
    {
        $this->categorieR = $categorieR;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaireR(): Collection
    {
        return $this->commentaireR;
    }

    public function addCommentaireR(Commentaire $commentaireR): self
    {
        if (!$this->commentaireR->contains($commentaireR)) {
            $this->commentaireR[] = $commentaireR;
            $commentaireR->setProduit($this);
        }

        return $this;
    }

    public function removeCommentaireR(Commentaire $commentaireR): self
    {
        if ($this->commentaireR->removeElement($commentaireR)) {
            // set the owning side to null (unless already changed)
            if ($commentaireR->getProduit() === $this) {
                $commentaireR->setProduit(null);
            }
        }

        return $this;
    }

    
}
