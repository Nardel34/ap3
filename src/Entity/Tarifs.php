<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TarifsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifsRepository::class)]
#[ApiResource]
class Tarifs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $TrancheAge;

    #[ORM\Column(type: 'string', length: 255)]
    private $Prix;

    #[ORM\OneToMany(mappedBy: 'tarifs', targetEntity: Personnes::class)]
    private $personnes;

    public function __construct()
    {
        $this->personnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrancheAge(): ?string
    {
        return $this->TrancheAge;
    }

    public function setTrancheAge(string $TrancheAge): self
    {
        $this->TrancheAge = $TrancheAge;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->Prix;
    }

    public function setPrix(string $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    /**
     * @return Collection|Personnes[]
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPersonne(Personnes $personne): self
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes[] = $personne;
            $personne->setTarifs($this);
        }

        return $this;
    }

    public function removePersonne(Personnes $personne): self
    {
        if ($this->personnes->removeElement($personne)) {
            // set the owning side to null (unless already changed)
            if ($personne->getTarifs() === $this) {
                $personne->setTarifs(null);
            }
        }

        return $this;
    }
}
