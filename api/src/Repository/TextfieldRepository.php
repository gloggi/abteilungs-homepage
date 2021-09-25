<?php

namespace App\Repository;

use App\Entity\Textfield;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Textfield|null find($id, $lockMode = null, $lockVersion = null)
 * @method Textfield|null findOneBy(array $criteria, array $orderBy = null)
 * @method Textfield[]    findAll()
 * @method Textfield[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TextfieldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Textfield::class);
    }

    // /**
    //  * @return Textfield[] Returns an array of Textfield objects
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
    public function findOneBySomeField($value): ?Textfield
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
