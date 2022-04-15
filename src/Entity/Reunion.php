<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReunionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReunionRepository::class)]
#[ApiResource]
class Reunion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $objet;

    #[ORM\ManyToMany(targetEntity: Personnes::class, inversedBy: 'reunions')]
    private $professeurs;

    #[ORM\ManyToMany(targetEntity: OrdreDuJour::class, inversedBy: 'reunions')]
    private $sujets;

    #[ORM\Column(type: 'datetime')]
    private $dateReunion;

    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
        $this->sujets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * @return Collection|Personnes[]
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Personnes $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs->add($professeur);
        }

        return $this;
    }

    public function removeProfesseur(Personnes $professeur): self
    {
        $this->professeurs->removeElement($professeur);

        return $this;
    }

    /**
     * @return Collection|OrdreDuJour[]
     */
    public function getSujets(): Collection
    {
        return $this->sujets;
    }

    public function addSujet(OrdreDuJour $sujet): self
    {
        if (!$this->sujets->contains($sujet)) {
            $this->sujets[] = $sujet;
        }

        return $this;
    }

    public function removeSujet(OrdreDuJour $sujet): self
    {
        $this->sujets->removeElement($sujet);

        return $this;
    }

    public function getDateReunion(): ?\DateTimeInterface
    {
        return $this->dateReunion;
    }

    public function setDateReunion(\DateTimeInterface $dateReunion): self
    {
        $this->dateReunion = $dateReunion;

        return $this;
    }
}
