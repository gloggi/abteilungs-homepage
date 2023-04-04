<?php

namespace App\Repository;

use App\Entity\PageItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageItem[]    findAll()
 * @method PageItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageItem::class);
    }

    // /**
    //  * @return PageItem[] Returns an array of PageItem objects
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
    public function findOneBySomeField($value): ?PageItem
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
