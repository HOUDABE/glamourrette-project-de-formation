<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateCommande;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandeR')]
    private $client;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeOneLine::class)]
    private $commandeOneLineR;

    public function __construct()
    {
        $this->commandeOneLineR = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

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
            $commandeOneLineR->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeOneLineR(CommandeOneLine $commandeOneLineR): self
    {
        if ($this->commandeOneLineR->removeElement($commandeOneLineR)) {
            // set the owning side to null (unless already changed)
            if ($commandeOneLineR->getCommande() === $this) {
                $commandeOneLineR->setCommande(null);
            }
        }

        return $this;
    }
}
