<?php

namespace App\Repository;

use App\Entity\ImageItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageItem[]    findAll()
 * @method ImageItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageItem::class);
    }

    // /**
    //  * @return ImageItem[] Returns an array of ImageItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageItem
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
