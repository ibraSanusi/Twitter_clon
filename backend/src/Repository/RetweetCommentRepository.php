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

    public function isRetweeted(int $userId, int $commentId): bool
    {
        // automatically knows to select RetweetComment
        // the "rc" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('rc')
            ->where('rc.user = :userId AND rc.comment = :commentId')
            ->setParameter('userId', $userId)
            ->setParameter('commentId', $commentId);

        $query = $qb->getQuery();

        $result = $query->getResult();

        return !empty($result);
    }

    public function getRetweetId(int $userId, int $commentId)
    {
        $qb = $this->createQueryBuilder('rc')
            ->where('rc.user = :userId AND rc.comment = :commentId')
            ->setParameter('userId', $userId)
            ->setParameter('commentId', $commentId);

        $query = $qb->getQuery();

        // Obtener un solo resultado o nulo
        return $query->getOneOrNullResult();
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
