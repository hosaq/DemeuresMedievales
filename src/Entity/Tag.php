<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"terme"},
 * message="ce tag existe déjà, merci de le modifier.")
 */
class Tag
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
    private $terme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Genresinterets", inversedBy="tags")
     */
    private $genreinteret;


     /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initialiseSlug(){
        if (empty($this->slug)){
            $slugify=new Slugify();
            $this->slug=$slugify->slugify($this->terme);
        }
    }

    public function __toString()
    {
        return $this->terme;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerme(): ?string
    {
        return $this->terme;
    }

    public function setTerme(string $terme): self
    {
        $this->terme = $terme;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getGenreinteret(): ?Genresinterets
    {
        return $this->genreinteret;
    }

    public function setGenreinteret(?Genresinterets $genreinteret): self
    {
        $this->genreinteret = $genreinteret;

        return $this;
    }
}
