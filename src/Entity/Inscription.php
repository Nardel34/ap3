<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[ApiResource]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Personnes::class, inversedBy: 'inscriptions')]
    private ?Personnes $eleves;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Evenement $evenements;

    #[ORM\Column(type: 'boolean')]
    private ?bool $Absence;

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
