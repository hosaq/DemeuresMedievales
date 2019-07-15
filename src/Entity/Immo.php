<?php

namespace App\Entity;

use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImmoRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"titre"},
 * message="Une autre annonce possède déjà ce titre, merci de le modifier.")
 * @Vich\Uploadable()
 */

class Immo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255, minMessage="Le titre, de votre annonce, doit comporter 
     * au moins 10 caractères !", maxMessage="Le titre, de votre annonce, ne 
     * pas doit comporter plus de 255 caractères !")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introduction;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $larges;

    /**
     * @var File|null
     * @Assert\Image( mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/svg+xml", "image/gif"})
     * @Vich\UploadableField(mapping="biens_larges", fileNameProperty="larges")
     */
    private $largesFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageLarge;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $surface;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $surfaceTerrain;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="immo", orphanRemoval=true
     * ,cascade={"persist","remove"})
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="immos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="annonce")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="annonce", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

     /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function __construct()
    {
        $this->date=new \DateTime();
        $this->images = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }
    /**
     * Calcule la moyenne des notes
     */
    public function moyenne(){
        $somme=array_reduce($this->commentaires->toArray(),
        function($total,$commentaire){return $total + $commentaire->getNote();
        },0);
        if (count($this->commentaires)>0) return $somme/count($this->commentaires);
        return 0;

    }
    /**
     * permet d'obtenir le commentaire d'une annonce pour son auteur
     */
    public function obtenircommentaireAuteur(User $auteur){
        foreach($this->commentaires as $commentaire){
            if($commentaire->getAuteur()===$auteur) return $commentaire;
        }
        return null;
    }

    /**
     * permet d'obtenir un tableau des dates indisponibles pour cette annonce
     * @return array
     */
    public function joursReserves(){
        $joursReserves=[];
        foreach($this->reservations as $reservation){
            $resultat=range(
                $reservation->getDateentree()->getTimestamp(),
                $reservation->getDatesortie()->getTimestamp(),
                24*60*60
            );
            $jours=array_map(function($dayTimestamp){
                return new\DateTime(date('Y-m-d',$dayTimestamp));
            },$resultat);
            $joursReserves=array_merge($joursReserves,$jours);
        }
        return $joursReserves;
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
            $this->slug=$slugify->slugify($this->titre);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

     /**
     * @return null|string
     */
    public function getLarges(): ?string
    {
        return $this->larges;
    }

    /**
     * @param null|string $larges
     * @return Immo
     */
    public function setLarges(?string $larges): Immo
    {
        $this->larges = $larges;
        return $this;
    }

    /**
     * @return null|File
     */
    public function getLargesFile(): ?File
    {
        return $this->largesFile;
    }

    /**
     * @param null|File $largesFile
     * @return Immo
     */
    public function setLargesFile(?File $largesFile): Immo
    {
        $this->largesFile = $largesFile;
        if ($this->largesFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
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


    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImageLarge(): ?string
    {
        return $this->imageLarge;
    }

    public function setImageLarge(?string $imageLarge): self
    {
        $this->imageLarge = $imageLarge;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(?int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getSurfaceTerrain(): ?int
    {
        return $this->surfaceTerrain;
    }

    public function setSurfaceTerrain(?int $surfaceTerrain): self
    {
        $this->surfaceTerrain = $surfaceTerrain;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setImmo($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getImmo() === $this) {
                $image->setImmo(null);
            }
        }

        return $this;
    }

    public function getProprio(): ?User
    {
        return $this->proprio;
    }

    public function setProprio(?User $proprio): self
    {
        $this->proprio = $proprio;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setAnnonce($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getAnnonce() === $this) {
                $reservation->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setAnnonce($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getAnnonce() === $this) {
                $commentaire->setAnnonce(null);
            }
        }

        return $this;
    }
}
