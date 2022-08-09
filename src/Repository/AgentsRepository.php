<?php

namespace App\Repository;

use App\Entity\Agents;
use App\Entity\Contrats;
use App\Entity\Comptes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
* @method Agents|null find($id, $lockMode = null, $lockVersion = null)
* @method Agents|null findOneBy(array $criteria, array $orderBy = null)
* @method Agents[]    findAll()
* @method Agents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/

class AgentsRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Agents::class);
  }

  // /**
  //  * @return Agents[] Returns an array of Agents objects
  //  */
  /*
  public function findByExampleField($value)
  {
  return $this->createQueryBuilder('a')
  ->andWhere('a.exampleField = :val')
  ->setParameter('val', $value)
  ->orderBy('a.id', 'ASC')
  ->setMaxResults(10)
  ->getQuery()
  ->getResult()
  ;
}
*/

// /**
//  * @return Agents[] Returns an array of Agents objects
//  */
public function searchAgents($criteria)
{
  $nom = $criteria->getNom();
  $prenom = $criteria->getPrenom();
  $matricule = $criteria->getMatricule();

  $requete = $this->createQueryBuilder('a');
  if (!empty($nom)){
    $requete->andWhere('a.Nom = :nom')
            ->setParameter('nom', $nom);
  }
  if (!empty($prenom)) {
    $requete->andWhere('a.Prenom = :prenom')
            ->setParameter('prenom', $prenom);
  }
  if (!empty($matricule)){
    $requete->andWhere('a.Matricule = :matricule')
            ->setParameter('matricule', $matricule);
  }
  return $requete->getQuery()
    ->getResult();
}

public function searchAgentsAPeuPres($criteria)
{
  $nom = $criteria->getNom();
  $prenom = $criteria->getPrenom();
  $matricule = $criteria->getMatricule();

  $requete = $this->createQueryBuilder('a');
  if (!empty($nom)){
    $requete->andWhere('a.Nom like :nom')
            ->setParameter('nom', '%'.$nom.'%');
  }
  if (!empty($prenom)) {
    $requete->andWhere('a.Prenom like :prenom')
            ->setParameter('prenom', '%'.$prenom.'%');
  }
  if (!empty($matricule)){
    $requete->andWhere('a.Matricule like :matricule')
            ->setParameter('matricule', '%'.$matricule.'%');
  }
  return $requete->getQuery()
    ->getResult();
}

public function generalSearch($criteria)
{
  $nom=$criteria->getNom();
  return $this->createQueryBuilder('b')
  ->orWhere('b.Nom like :criteria')
  ->setParameter('criteria', '%'.$nom.'%')
  ->orWhere('b.Matricule like :criteria')
  ->setParameter('criteria', '%'.$nom.'%')
  ->getQuery()
  ->getResult();
}

public function adez(){

  $dday = date('Y-m-d');

  return $this->createQueryBuilder('d')
    ->join('App\Entity\Contrats', 'contrats')
    ->join('App\Entity\Comptes', 'comptes')
    ->andWhere('comptes.actif = :actif')
    ->setParameter('actif', 1)
    ->andWhere('contrats.DateFin < :dday')
    ->setParameter('dday', $dday)
    ->getQuery()
    ->getResult();

}




// public function findOneBySomeField($value): ?Agents
// {
//   return $this->createQueryBuilder('a')
//   ->andWhere('a.exampleField = :val')
//   ->setParameter('val', $value)
//   ->getQuery()
//   ->getOneOrNullResult()
//   ;
// }

}
