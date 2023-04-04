<?php

namespace App\Repository;

use App\Entity\TextItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TextItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method TextItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method TextItem[]    findAll()
 * @method TextItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TextItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TextItem::class);
    }

    // /**
    //  * @return TextItem[] Returns an array of TextItem objects
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
    public function findOneBySomeField($value): ?TextItem
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
