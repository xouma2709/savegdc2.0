<?php

namespace App\Repository;

use App\Entity\Softs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Softs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Softs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Softs[]    findAll()
 * @method Softs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoftsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Softs::class);
    }

    // /**
    //  * @return Softs[] Returns an array of Softs objects
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
    public function findOneBySomeField($value): ?Softs
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
