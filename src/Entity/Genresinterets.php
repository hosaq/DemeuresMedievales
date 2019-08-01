<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenresinteretsRepository")
 */
class Genresinterets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Interets", mappedBy="genresinterets")
     */
    private $interets;

    public function __construct()
    {
        $this->interets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Interets[]
     */
    public function getInterets(): Collection
    {
        return $this->interets;
    }

    public function addInteret(Interets $interet): self
    {
        if (!$this->interets->contains($interet)) {
            $this->interets[] = $interet;
            $interet->setGenresinterets($this);
        }

        return $this;
    }

    public function removeInteret(Interets $interet): self
    {
        if ($this->interets->contains($interet)) {
            $this->interets->removeElement($interet);
            // set the owning side to null (unless already changed)
            if ($interet->getGenresinterets() === $this) {
                $interet->setGenresinterets(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
