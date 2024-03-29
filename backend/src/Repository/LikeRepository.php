<?php

namespace App\Repository;

use App\Entity\Like;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Like>
 *
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    public function isLiked(int $userId, int $tweetId): bool
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('l')
            ->where('l.user = :userId AND l.tweet = :tweetId')
            ->setParameter('userId', $userId)
            ->setParameter('tweetId', $tweetId);

        $query = $qb->getQuery();

        $result = $query->getResult();

        return !empty($result);
    }

    public function getLikeId(int $userId, int $tweetId)
    {
        $qb = $this->createQueryBuilder('l')
            ->where('l.user = :userId AND l.tweet = :tweetId')
            ->setParameter('userId', $userId)
            ->setParameter('tweetId', $tweetId);

        $query = $qb->getQuery();

        // Obtener un solo resultado o nulo
        return $query->getOneOrNullResult();
    }


    //    /**
    //     * @return Like[] Returns an array of Like objects
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

    //    public function findOneBySomeField($value): ?Like
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
