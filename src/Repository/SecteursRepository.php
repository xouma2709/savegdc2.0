<?php

namespace App\Repository;

use App\Entity\Secteurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Secteurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Secteurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Secteurs[]    findAll()
 * @method Secteurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecteursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Secteurs::class);
    }

    // /**
    //  * @return Secteurs[] Returns an array of Secteurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Secteurs
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
