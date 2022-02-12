<?php

namespace App\Repository;

use App\Entity\OrdreDuJour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrdreDuJour|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdreDuJour|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdreDuJour[]    findAll()
 * @method OrdreDuJour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdreDuJourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdreDuJour::class);
    }

    // /**
    //  * @return OrdreDuJour[] Returns an array of OrdreDuJour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrdreDuJour
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
