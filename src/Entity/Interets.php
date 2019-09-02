<?php

namespace App\Entity;

use DateTimeInterface;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InteretsRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"nom"},
 * message="Un autre centre d'intérêt possède déjà ce nom, merci de l'utiliser.")
 * @Vich\Uploadable()
 */
class Interets
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $type1;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Assert\NotBlank()
     */
    private $type2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $pays;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $photo1;
    
    /**
     * @var File|null
     * @Assert\Image( mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/svg+xml", "image/gif"})
     * @Vich\UploadableField(mapping="interets_photo1", fileNameProperty="photo1")
     */
    private $photo1File;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $photo2;
    
     /**
     * @var File|null
     * @Assert\Image( mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/svg+xml", "image/gif"})
     * @Vich\UploadableField(mapping="interets_photo2", fileNameProperty="photo2")
     */
    private $photo2File;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $photo3;
    
     /**
     * @var File|null
     * @Assert\Image( mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/svg+xml", "image/gif"})
     * @Vich\UploadableField(mapping="interets_photo3", fileNameProperty="photo3")
     */
    private $photo3File;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Immo", mappedBy="centreinterets")
     */
    private $immos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="interets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Genresinterets", inversedBy="interets")
     */
    private $genresinterets;

    public function __construct()
    {
        $this->date=new \DateTime();
        $this->immos = new ArrayCollection();
    }

     /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initialiseSlug(){
        if (empty($this->slug)){
            $slugify=new Slugify();
            $this->slug=$slugify->slugify($this->nom);
        }
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }


    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(?string $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(?int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

     /**
     * @return Collection|Immos[]
     */
    public function getImmos(): Collection
    {
        return $this->immos;
    }

    public function addImmo(Immo $immo): self
    {
        if (!$this->immos->contains($immo)) {
            $this->immos[] = $immo;
            $immo->addCentreinteret($this);
        }

        return $this;
    }

    public function removeImmo(Immo $immo): self
    {
        if ($this->immos->contains($immo)) {
            $this->immos->removeElement($immo);
            $immo->removeCentreinteret($this);
        }

        return $this;
    }

        /**
     * @return null|string
     */
    public function getPhoto1(): ?string
    {
        return $this->photo1;
    }
    
     /**
     * @param null|string $photo1
     * @return Interets
     */
    public function setPhoto1(?string $photo1): Interets
    {
        $this->photo1 = $photo1;

        return $this;
    }
    
    /**
     * @return null|File
     */ 
    public function getPhoto1File(): ?File
    {
        return $this->photo1File;
    }

    /**
     * @param null|File $photo1File
     * @return Interets
     */
    public function setPhoto1File(?File $photo1File): Interets
    {
        $this->photo1File = $photo1File;
        if ($this->photo1File instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getPhoto2(): ?string
    {
        return $this->photo2;
    }
    
    /**
     * @param null|string $photo2
     * @return Interets
     */
    public function setPhoto2(?string $photo2): Interets
    {
        $this->photo2 = $photo2;

        return $this;
    }
    
    /**
     * @return null|File
     */
 
    public function getPhoto2File(): ?File
    {
        return $this->photo2File;
    }

    /**
     * @param null|File $photo2File
     * @return Interets
     */
    public function setPhoto2File(?File $photo2File): Interets
    {
        $this->photo2File = $photo2File;
        if ($this->photo2File instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getPhoto3(): ?string
    {
        return $this->photo3;
    }
    
    /**
     * @param null|string $photo3
     * @return Interets
     */
    public function setPhoto3(?string $photo3): Interets
    {
        $this->photo3 = $photo3;

        return $this;
    }

     /**
     * @return null|File
     */
 
    public function getPhoto3File(): ?File
    {
        return $this->photo3File;
    }

    /**
     * @param null|File $photo3File
     * @return Interets
     */
    public function setPhoto3File(?File $photo3File): Interets
    {
        $this->photo3File = $photo3File;
        if ($this->photo3File instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getCreateur(): ?user
    {
        return $this->createur;
    }

    public function setCreateur(?user $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getGenresinterets(): ?Genresinterets
    {
        return $this->genresinterets;
    }

    public function setGenresinterets(?Genresinterets $genresinterets): self
    {
        $this->genresinterets = $genresinterets;

        return $this;
    }
}
