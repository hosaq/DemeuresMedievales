<?php

namespace App\Repository;

use App\Entity\Interets;
use App\Entity\InteretsRecherche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Interets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interets[]    findAll()
 * @method Interets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteretsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Interets::class);
    }
    
    
    
    
    public function findAllVisibleQuery(InteretsRecherche $recherche){
        
        
        $query=$this->createQueryBuilder('p');
        if ($recherche->getNom()) {
            $query = $query
            ->andWhere('p.nom = :val')
            ->setParameter('val', $recherche->getNom())
            /*->orderBy('p.id', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()*/
        ;
    }
        
        if ($recherche->getLat() && $recherche->getLng() && $recherche->getDistance()) {
            $query = $query
                ->select('p')
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) *  pi()/180 / 2), 2) +COS(p.lat * pi()/180) * COS(:lat * pi()/180) * POWER(SIN((p.lng - :lng) * pi()/180 / 2), 2) ))) <= :distance')
                ->setParameter('lng', $recherche->getLng())
                ->setParameter('lat', $recherche->getLat())
                ->setParameter('distance', $recherche->getDistance());
        }
        
        if($recherche->getVille()){
            $query=$query
                    ->andWhere('p.ville= :ville')
                    ->setParameter('ville', $recherche->getVille());
        }
        return $query->getQuery();
    }

    // /**
    //  * @return Interets[] Returns an array of Interets objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Interets
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
