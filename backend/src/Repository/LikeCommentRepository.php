<?php

namespace App\Repository;

use App\Entity\LikeComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LikeComment>
 *
 * @method LikeComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeComment[]    findAll()
 * @method LikeComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LikeComment::class);
    }

    public function isLiked(int $userId, int $commentId): bool
    {
        // automatically knows to select comments
        // the "lc" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('lc')
            ->where('lc.user = :userId AND lc.comment = :commentId')
            ->setParameter('userId', $userId)
            ->setParameter('commentId', $commentId);

        $query = $qb->getQuery();

        $result = $query->getResult();

        return !empty($result);
    }

    public function getLikeId(int $userId, int $commentId)
    {
        $qb = $this->createQueryBuilder('lc')
            ->where('lc.user = :userId AND lc.comment = :commentId')
            ->setParameter('userId', $userId)
            ->setParameter('commentId', $commentId);

        $query = $qb->getQuery();

        // Obtener un solo resultado o nulo
        return $query->getOneOrNullResult();
    }

    //    /**
    //     * @return LikeComment[] Returns an array of LikeComment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LikeComment
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
