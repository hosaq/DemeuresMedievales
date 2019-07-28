<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"email"},
 * message="Un autre utilisateur s'est déjà inscrit avec cette adresse mail, merci de la modifier !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner votre nom.")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner votre prénom.")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Vérifiez votre adresse mail, son format ne semble pas valide.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Vérifiez l'Url de votre avatar, son format ne 
     * semble pas valide.")
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @Assert\EqualTo(propertyPath="hash",message="Votre confirmation est incorrecte")
     */
    public $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $introduction;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Immo", mappedBy="proprio", orphanRemoval=true)
     */
    private $immos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="membres")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="booker")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="auteur", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Interets", mappedBy="createur")
     */
    private $interets;

    public function getIdentite(){
        return "{$this->prenom} {$this->nom}";
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
            $this->slug=$slugify->slugify($this->prenom.' '.$this->nom);
        }
    }

    public function __construct()
    {
        $this->immos = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection|Immo[]
     */
    public function getImmos(): Collection
    {
        return $this->immos;
    }

    public function addImmo(Immo $immo): self
    {
        if (!$this->immos->contains($immo)) {
            $this->immos[] = $immo;
            $immo->setProprio($this);
        }

        return $this;
    }

    public function removeImmo(Immo $immo): self
    {
        if ($this->immos->contains($immo)) {
            $this->immos->removeElement($immo);
            // set the owning side to null (unless already changed)
            if ($immo->getProprio() === $this) {
                $immo->setProprio(null);
            }
        }

        return $this;
    }

    public function getRoles(){
        $roles=$this->userRoles->map(function($role){
            return $role->getTitre();
        })->toArray();
        $roles[]='ROLE_USER';
        return $roles;
    }
    public function getPassword(){
        return $this->hash;
    }
    public function getSalt(){

    }
    public function getUsername(){
        return $this->email;
    }
    public function eraseCredentials(){

    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addMembre($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeMembre($this);
        }

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
            $reservation->setBooker($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getBooker() === $this) {
                $reservation->setBooker(null);
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
            $commentaire->setAuteur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuteur() === $this) {
                $commentaire->setAuteur(null);
            }
        }

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
            $interet->setCreateur($this);
        }

        return $this;
    }

    public function removeInteret(Interets $interet): self
    {
        if ($this->interets->contains($interet)) {
            $this->interets->removeElement($interet);
            // set the owning side to null (unless already changed)
            if ($interet->getCreateur() === $this) {
                $interet->setCreateur(null);
            }
        }

        return $this;
    }
}
