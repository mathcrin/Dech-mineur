<?php

namespace App\Repository;

use App\Entity\PlatV2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlatV2|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlatV2|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlatV2[]    findAll()
 * @method PlatV2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatV2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlatV2::class);
    }

    // /**
    //  * @return PlatV2[] Returns an array of PlatV2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlatV2
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
