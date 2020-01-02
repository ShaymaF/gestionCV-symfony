<?php

namespace App\Repository;

use App\Entity\Connaissances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Connaissances|null find($id, $lockMode = null, $lockVersion = null)
 * @method Connaissances|null findOneBy(array $criteria, array $orderBy = null)
 * @method Connaissances[]    findAll()
 * @method Connaissances[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnaissancesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Connaissances::class);
    }

    // /**
    //  * @return Connaissances[] Returns an array of Connaissances objects
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

    /*
    public function findOneBySomeField($value): ?Connaissances
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
