<?php

namespace App\Repository;

use App\Entity\ModificationMdp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModificationMdp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModificationMdp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModificationMdp[]    findAll()
 * @method ModificationMdp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModificationMdpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModificationMdp::class);
    }

    // /**
    //  * @return ModificationMdp[] Returns an array of ModificationMdp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModificationMdp
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
