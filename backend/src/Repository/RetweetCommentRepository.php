<?php

namespace App\Repository;

use App\Entity\RetweetComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RetweetComment>
 *
 * @method RetweetComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method RetweetComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method RetweetComment[]    findAll()
 * @method RetweetComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetweetCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RetweetComment::class);
    }

//    /**
//     * @return RetweetComment[] Returns an array of RetweetComment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RetweetComment
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
