<?php

namespace App\Repository;

use App\Entity\Retweet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Retweet>
 *
 * @method Retweet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Retweet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Retweet[]    findAll()
 * @method Retweet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetweetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Retweet::class);
    }

    public function isRetweeted(int $userId, int $tweetId): bool
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('r')
            ->where('r.user = :userId AND r.tweet = :tweetId')
            ->setParameter('userId', $userId)
            ->setParameter('tweetId', $tweetId);

        $query = $qb->getQuery();

        $result = $query->getResult();

        return !empty($result);
    }

    public function getRetweetId(int $userId, int $tweetId)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.user = :userId AND r.tweet = :tweetId')
            ->setParameter('userId', $userId)
            ->setParameter('tweetId', $tweetId);

        $query = $qb->getQuery();

        // Obtener un solo resultado o nulo
        return $query->getOneOrNullResult();
    }

    //    /**
    //     * @return Retweet[] Returns an array of Retweet objects
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

    //    public function findOneBySomeField($value): ?Retweet
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
