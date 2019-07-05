<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Immo", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention, la date d'arrivée doit-être au bon format.")
     * @Assert\GreaterThan("today",message="La date d'arrivée doit-être ultérieure à celle d'aujourd'hui !")
     */
    private $dateentree;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention, la date de sortie doit-être au bon format.")
     * @Assert\GreaterThan(propertyPath="dateentree",message="La date de sortie doit-être ultérieure à celle d'arrivée !")
     */
    private $datesortie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creele;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $montant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * /insere la date de creation et le prix
     * @ORM\PrePersist
     */

    public function prePersist(){
        if(empty($this->creele)){
            $this->creele=new \DateTime();
        }
        if(empty($this->montant)){
            $this->montant=$this->annonce->getPrix() * $this->duree();
        }
    }
    /**
     * Calcul le nombre de jours que compte la reservation
     * @return int
     */
    public function duree(){
        $diff=$this->datesortie->diff($this->dateentree);
        return $diff->days;
    }

    /**
     * Permet de savoir si les dates choisies sont réservables
     * 
     * 
     */
    public function sontReservables(){
        $joursReserves=$this->annonce->joursReserves();
        $joursReservation=$this->joursdate();

        $jours=array_map(function($day){
            return $day->format('Y-m-d');
        },$joursReservation);

        $joursnon=array_map(function($day){
            return $day->format('Y-m-d');
        },$joursReserves);

        foreach($jours as $jour){
            if(array_search($jour,$joursnon) !== false) return false;        
        }
        return true;
    }
    
    /** 
     * Permet de recuperer un tableau des journées correspondant à la réservation
     * @return array
    */
    public function joursdate(){
        $resultat=range(
            $this->dateentree->getTimestamp(),
            $this->datesortie->getTimestamp(),
            24*60*60
        );
        $jours=array_map(function($dayTimestamp){
            return new\DateTime(date('Y-m-d',$dayTimestamp));
        },$resultat);
        return $jours;
    }
    public function getProprio(): ?User
    {
        return $this->annonce->getProprio();
    }
    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getAnnonce(): ?Immo
    {
        return $this->annonce;
    }

    public function setAnnonce(?Immo $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getDateentree(): ?\DateTimeInterface
    {
        return $this->dateentree;
    }

    public function setDateentree(\DateTimeInterface $dateentree): self
    {
        $this->dateentree = $dateentree;

        return $this;
    }

    public function getDatesortie(): ?\DateTimeInterface
    {
        return $this->datesortie;
    }

    public function setDatesortie(\DateTimeInterface $datesortie): self
    {
        $this->datesortie = $datesortie;

        return $this;
    }

    public function getCreele(): ?\DateTimeInterface
    {
        return $this->creele;
    }

    public function setCreele(\DateTimeInterface $creele): self
    {
        $this->creele = $creele;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
