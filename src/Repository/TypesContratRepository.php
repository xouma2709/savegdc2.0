<?php

namespace App\Repository;

use App\Entity\TypesContrat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypesContrat|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypesContrat|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypesContrat[]    findAll()
 * @method TypesContrat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypesContratRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypesContrat::class);
    }

    // /**
    //  * @return TypesContrat[] Returns an array of TypesContrat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypesContrat
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
