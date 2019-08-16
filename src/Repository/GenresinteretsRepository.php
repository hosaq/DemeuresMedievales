<?php

namespace App\Repository;

use App\Entity\Genresinterets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Genresinterets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genresinterets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genresinterets[]    findAll()
 * @method Genresinterets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenresinteretsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Genresinterets::class);
    }

    // /**
    //  * @return Genresinterets[] Returns an array of Genresinterets objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneByNom($value): ?Genresinterets
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.nom = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
