<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Personnes::class, inversedBy: 'inscriptions')]
    private $eleves;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'inscriptions')]
    private $evenements;

    #[ORM\Column(type: 'boolean')]
    private $Absence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEleves(): ?Personnes
    {
        return $this->eleves;
    }

    public function setEleves(?Personnes $eleves): self
    {
        $this->eleves = $eleves;

        return $this;
    }

    public function getEvenements(): ?Evenement
    {
        return $this->evenements;
    }

    public function setEvenements(?Evenement $evenements): self
    {
        $this->evenements = $evenements;

        return $this;
    }

    public function getAbsence(): ?bool
    {
        return $this->Absence;
    }

    public function setAbsence(bool $Absence): self
    {
        $this->Absence = $Absence;

        return $this;
    }
}
