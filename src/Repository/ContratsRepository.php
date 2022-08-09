<?php

namespace App\Repository;

use App\Entity\Contrats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contrats|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contrats|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contrats[]    findAll()
 * @method Contrats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrats::class);
    }

    // /**
    //  * @return Contrats[] Returns an array of Contrats objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function contratsPasses()
    {
      $date = date('Y-m-d');
      return $this->createQueryBuilder('c')
        ->andWhere('c.DateFin < :dday')
        ->setParameter('dday', $date)
        ->getQuery()
        ->getResult()
        ;
      }

      public function dernierContrat($criteria){

        return $this->createQueryBuilder('e')
        ->andWhere('e.agents = :agent')
        ->setParameter('agent', $criteria)
        ->orderBy('e.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getResult();
      }



    /*
    public function findOneBySomeField($value): ?Contrats
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
