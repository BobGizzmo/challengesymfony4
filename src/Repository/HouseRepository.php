<?php

namespace App\Repository;

use App\Entity\House;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method House|null find($id, $lockMode = null, $lockVersion = null)
 * @method House|null findOneBy(array $criteria, array $orderBy = null)
 * @method House[]    findAll()
 * @method House[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, House::class);
    }

    // /**
    //  * @return House[] Returns an array of House objects
    //  */
    public function findLast($maxResult) {
        return $this->createQueryBuilder('h') //SELECT * FROM house
                    ->setMaxResults($maxResult) //LIMIT $maxResult
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return House[] Returns an array of House objects
    //  */
    public function findByPage($page, $maxResult) {
        return $this->createQueryBuilder('h') //Select * FROM house 
                    ->setMaxResults($maxResult) //LIMIT $maxResult
                    ->setFirstResult($page*$maxResult) //OFFSET $page*$maxResult
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return House[] Returns an array of House objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?House
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
