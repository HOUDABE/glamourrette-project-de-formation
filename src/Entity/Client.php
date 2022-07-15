<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomClient;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenomClient;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private $commandeR;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commentaire::class)]
    private $commentaireR;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->commandeR = new ArrayCollection();
        $this->commentaireR = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(string $prenomClient): self
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandeR(): Collection
    {
        return $this->commandeR;
    }

    public function addCommandeR(Commande $commandeR): self
    {
        if (!$this->commandeR->contains($commandeR)) {
            $this->commandeR[] = $commandeR;
            $commandeR->setClient($this);
        }

        return $this;
    }

    public function removeCommandeR(Commande $commandeR): self
    {
        if ($this->commandeR->removeElement($commandeR)) {
            // set the owning side to null (unless already changed)
            if ($commandeR->getClient() === $this) {
                $commandeR->setClient(null);
            }
        }

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
            $commentaireR->setClient($this);
        }

        return $this;
    }

    public function removeCommentaireR(Commentaire $commentaireR): self
    {
        if ($this->commentaireR->removeElement($commentaireR)) {
            // set the owning side to null (unless already changed)
            if ($commentaireR->getClient() === $this) {
                $commentaireR->setClient(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    public function __toString()
    {
        return strval($this->password);
    }
}
