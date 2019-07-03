<?php
namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class StatsService{
    private $manager;

    public function __construct(ObjectManager $manager){
        $this->manager=$manager;
    }
    public function getStats(){
        $users        = $this->compteUsers();
        $annonces     = $this->compteAnnonces();
        $reservations = $this->compteReserves();
        $commentaires = $this->compteAvis();

        return compact('users','annonces','reservations','commentaires');
    }

    public function compteUsers(){
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')
        ->getSingleScalarResult();
    }
    public function compteAnnonces(){
        return $this->manager->createQuery('SELECT COUNT(i) FROM App\Entity\Immo i')
        ->getSingleScalarResult();
    }
    public function compteReserves(){
        return $this->manager->createQuery('SELECT COUNT(r) FROM App\Entity\Reservation r')
        ->getSingleScalarResult();
    }
    public function compteAvis(){
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Commentaire c')
        ->getSingleScalarResult();
    }

    public function getLesplus($ordre){
        return $this->manager->createQuery('SELECT AVG(c.note) as note, i.titre,
        i.id, u.nom, u.prenom,u.avatar FROM App\Entity\Commentaire c
        JOIN c.annonce i
        JOIN i.proprio u
        GROUP BY i
        ORDER BY note '.$ordre
        )
        ->setMaxResults(5)
        ->getResult();

    }
}

?>