<?php

namespace App\Repository;

use App\Entity\Reseaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reseaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reseaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reseaux[]    findAll()
 * @method Reseaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReseauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reseaux::class);
    }

    // /**
    //  * @return Reseaux[] Returns an array of Reseaux objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reseaux
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
