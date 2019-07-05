<?php

namespace App\Repository;

use App\Entity\Immo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Immo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Immo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Immo[]    findAll()
 * @method Immo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Immo::class);
    }

    // /**
    //  * @return Immo[] Returns an array of Immo objects
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
    public function findOneBySomeField($value): ?Immo
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function bonsGites($nb=3){
        return $this->createQueryBuilder('a')
                    ->select('a as annonce','AVG(c.note) as notemoyenne')
                    ->join('a.commentaires','c')
                    ->groupBy('a')
                    ->orderBy('notemoyenne','DESC')
                    ->setMaxResults($nb)
                    ->getQuery()
                    ->getResult();

    }

    /**
     * retourne les annonces d'un proprio
    * @return Immo[] Returns an array of Immo objects
    */
    
    public function findByProprio($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.proprio = :val')
            ->setParameter('val', $value)
            ->orderBy('i.prix', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }
}
