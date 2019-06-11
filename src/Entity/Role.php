<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
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
    private $titre;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="userRoles")
     */
    private $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(User $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
        }

        return $this;
    }

    public function removeMembre(User $membre): self
    {
        if ($this->membres->contains($membre)) {
            $this->membres->removeElement($membre);
        }

        return $this;
    }
}
