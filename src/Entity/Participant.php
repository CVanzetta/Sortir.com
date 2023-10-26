<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Participant implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[ORM\Column(length: 55)]
    private ?string $nom = null;

    #[ORM\Column(length: 55)]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;


    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $motPasse = null;
    #[ORM\Column]
    private ?bool $administrateur = null;

    #[ORM\Column]
    private ?bool $actif = null;


    #[ORM\ManyToOne(inversedBy: 'participants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    #[ORM\OneToMany(mappedBy: 'organisateur', targetEntity: Sortie::class)]
    private Collection $sortiesOrganiser;

    #[ORM\ManyToMany(targetEntity: Sortie::class, mappedBy: 'participants')]
    private Collection $sorties;

    public function __construct()
    {
        $this->sortiesOrganiser = new ArrayCollection();
        $this->sorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->motPasse;
    }

    public function isAdministrateur(): ?bool
    {
        return $this->administrateur;
    }

    public function setAdministrateur(bool $administrateur): static
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): static
    {
        $this->campus = $campus;
        return $this;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getMotPasse(): ?string
    {
        return $this->motPasse;
    }

    public function setMotPasse(?string $motPasse): void
    {
        $this->motPasse = $motPasse;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSortiesOrganiser(): Collection
    {
        return $this->sortiesOrganiser;
    }

    public function addSortiesOrganiser(Sortie $sortiesOrganiser): static
    {
        if (!$this->sortiesOrganiser->contains($sortiesOrganiser)) {
            $this->sortiesOrganiser->add($sortiesOrganiser);
            $sortiesOrganiser->setOrganisateur($this);
        }

        return $this;
    }

    public function removeSortiesOrganiser(Sortie $sortiesOrganiser): static
    {
        if ($this->sortiesOrganiser->removeElement($sortiesOrganiser)) {
            // set the owning side to null (unless already changed)
            if ($sortiesOrganiser->getOrganisateur() === $this) {
                $sortiesOrganiser->setOrganisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): static
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties->add($sorty);
            $sorty->addParticipant($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): static
    {
        if ($this->sorties->removeElement($sorty)) {
            $sorty->removeParticipant($this);
        }

        return $this;
    }

    /**
    * @see UserInterface
    */
    public function getRoles(): array
    {
        if ($this -> administrateur) {
            return ['ROLE_ADMIN'];
        }
        else {
            return ['ROLE_USER'];
        }

    }
}
