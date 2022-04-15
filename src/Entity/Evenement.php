<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EvenementRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ApiResource]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "Veuillez entrer une date")]
    private ?DateTime $dateEvent;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Veuillez entrer un type")]
    private ?Type $type;

    #[ORM\ManyToOne(targetEntity: Lieu::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Veuillez entrer un lieu")]
    private ?Lieu $lieu;

    #[ORM\ManyToOne(targetEntity: Personnes::class, inversedBy: 'evenements')]
    #[Assert\NotBlank(message: "Veuillez choisir un remplacant ou annuler")]
    private ?Personnes $personnes;

    #[ORM\OneToMany(mappedBy: 'evenements', targetEntity: Inscription::class)]
    private $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;
        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getPersonnes(): ?Personnes
    {
        return $this->personnes;
    }

    public function setPersonnes(?Personnes $personnes): self
    {
        $this->personnes = $personnes;

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
            $inscription->setEvenements($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEvenements() === $this) {
                $inscription->setEvenements(null);
            }
        }

        return $this;
    }
}
