<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrdreDuJourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdreDuJourRepository::class)]
#[ApiResource]
class OrdreDuJour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $sujet;

    #[ORM\ManyToMany(targetEntity: Reunion::class, mappedBy: 'sujets')]
    private $reunions;

    public function __construct()
    {
        $this->reunions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

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
            $reunion->addSujet($this);
        }

        return $this;
    }

    public function removeReunion(Reunion $reunion): self
    {
        if ($this->reunions->removeElement($reunion)) {
            $reunion->removeSujet($this);
        }

        return $this;
    }
}
