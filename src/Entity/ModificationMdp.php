<?php

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;

class ModificationMdp
{
    
    
    private $ancienmdp;

    /**
     * @Assert\Length(min=8, max=255, minMessage="Votre mot de passe doit comporter 
     * au moins 8 caractères !")
     */
    private $nouveaumdp;

    /**
     * @Assert\EqualTo(propertyPath="nouveaumdp",message="Votre confirmation est incorrecte")
     */
    private $confirmmdp;

    

    public function getAncienmdp(): ?string
    {
        return $this->ancienmdp;
    }

    public function setAncienmdp(string $ancienmdp): self
    {
        $this->ancienmdp = $ancienmdp;

        return $this;
    }

    public function getNouveaumdp(): ?string
    {
        return $this->nouveaumdp;
    }

    public function setNouveaumdp(string $nouveaumdp): self
    {
        $this->nouveaumdp = $nouveaumdp;

        return $this;
    }

    public function getConfirmmdp(): ?string
    {
        return $this->confirmmdp;
    }

    public function setConfirmmdp(string $confirmmdp): self
    {
        $this->confirmmdp = $confirmmdp;

        return $this;
    }
}
