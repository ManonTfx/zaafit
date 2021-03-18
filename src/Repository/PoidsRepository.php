<?php

namespace App\Repository;

use App\Entity\Poids;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Poids|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poids|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poids[]    findAll()
 * @method Poids[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoidsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poids::class);
    }

    // /**
    //  * @return Poids[] Returns an array of Poids objects
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
    public function findOneBySomeField($value): ?Poids
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
