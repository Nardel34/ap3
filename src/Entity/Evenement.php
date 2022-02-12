<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateEvent;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Lieu::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private $lieu;

    #[ORM\ManyToOne(targetEntity: Personnes::class, inversedBy: 'evenements')]
    private $personnes;

    #[ORM\ManyToMany(targetEntity: Personnes::class, inversedBy: 'participations')]
    private $Inscrits;

    public function __construct()
    {
        $this->inscrits = new ArrayCollection();
        $this->Inscrits = new ArrayCollection();
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
     * @return Collection|Personnes[]
     */
    public function getInscrits(): Collection
    {
        return $this->Inscrits;
    }

    public function addInscrit(Personnes $inscrit): self
    {
        if (!$this->Inscrits->contains($inscrit)) {
            $this->Inscrits[] = $inscrit;
        }

        return $this;
    }

    public function removeInscrit(Personnes $inscrit): self
    {
        $this->Inscrits->removeElement($inscrit);

        return $this;
    }
}
