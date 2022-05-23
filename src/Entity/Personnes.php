<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\MeController;
use App\Repository\PersonnesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints as Assert_doctrine;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[Assert_doctrine\UniqueEntity('email', message: "L'adresse Email est déjà utilisée")]
#[ORM\Entity(repositoryClass: PersonnesRepository::class)]
#[ApiResource(
    collectionOperations: [
        'create' => [
            'path' => '/create',
            'method' => 'post',
        ],
    ],
    normalizationContext: ['groups' => ['read:User']],
    denormalizationContext: ['groups' => ['write:User']]
)]
class Personnes implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:User'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: "Veuillez entrer une adresse Email")]
    #[Groups(['read:User', 'write:User'])]
    private ?string $email;

    #[ORM\Column(type: 'json')]
    #[Groups(['read:User', 'write:User'])]
    private ?array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: "Veuillez entrer un mot de passe")]
    #[Groups(['write:User'])]
    private ?string $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Veuillez entrer un nom")]
    #[Groups(['read:User', 'write:User'])]
    private ?string $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Veuillez entrer un prénom")]
    #[Groups(['read:User', 'write:User'])]
    private ?string $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Veuillez entrer votre âge")]
    #[Groups(['write:User'])]
    private ?string $age;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['write:User'])]
    private ?string $DateEntree;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    // #[Assert\NotBlank(message: "Veuillez entrer un diplôme")]
    #[Groups(['write:User'])]
    private ?string $diplome;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    // #[Assert\NotBlank(message: "Veuillez entrer une expérience professionel")]
    #[Groups(['write:User'])]
    private ?string $expPro;

    #[ORM\ManyToOne(targetEntity: Tarifs::class, inversedBy: 'personnes')]
    #[Groups(['write:User'])]
    private ?Tarifs $tarifs;

    #[ORM\OneToMany(mappedBy: 'personnes', targetEntity: Evenement::class)]
    private Collection $evenements;

    #[ORM\ManyToMany(targetEntity: Reunion::class, mappedBy: 'professeurs')]
    private Collection $reunions;

    #[ORM\OneToMany(mappedBy: 'eleves', targetEntity: Inscription::class)]
    private $inscriptions;

    public function __toString(): string
    {
        return  strtoupper($this->getNom()) . ' ' . $this->getPrenom();
    }

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->reunions = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getDateEntree(): ?string
    {
        return $this->DateEntree;
    }

    public function setDateEntree(?string $DateEntree): self
    {
        $this->DateEntree = $DateEntree;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(?string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getExpPro(): ?string
    {
        return $this->expPro;
    }

    public function setExpPro(?string $expPro): self
    {
        $this->expPro = $expPro;

        return $this;
    }

    public function getTarifs(): ?Tarifs
    {
        return $this->tarifs;
    }

    public function setTarifs(?Tarifs $tarifs): self
    {
        $this->tarifs = $tarifs;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setPersonnes($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getPersonnes() === $this) {
                $evenement->setPersonnes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reunion[]
     */
    public function getReunions(): Collection
    {
        return $this->reunions;
    }

    public function addReunion(Reunion $reunion): self
    {
        if (!$this->reunions->contains($reunion)) {
            $this->reunions[] = $reunion;
            $reunion->addProfesseur($this);
        }

        return $this;
    }

    public function removeReunion(Reunion $reunion): self
    {
        if ($this->reunions->removeElement($reunion)) {
            $reunion->removeProfesseur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setEleves($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEleves() === $this) {
                $inscription->setEleves(null);
            }
        }

        return $this;
    }
}
