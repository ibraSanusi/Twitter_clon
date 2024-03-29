<?php

namespace App\Repository;

use App\Entity\Follower;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Follower>
 *
 * @method Follower|null find($id, $lockMode = null, $lockVersion = null)
 * @method Follower|null findOneBy(array $criteria, array $orderBy = null)
 * @method Follower[]    findAll()
 * @method Follower[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Follower::class);
    }

    public function getFollowId(int $followerId, int $followingId)
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.follower = :followerId AND f.following = :followingId')
            ->setParameter('followerId', $followerId)
            ->setParameter('followingId', $followingId);

        $query = $qb->getQuery();

        // Obtener un solo resultado o nulo
        return $query->getOneOrNullResult();
    }

    // Sacar usuario y cantidad de followers ordenado por cantidad de seguidos
    public function getTopFiveFollowed()
    {
        $qb = $this->createQueryBuilder('f')
            ->select('f.following', 'COUNT(f.follower) as follower_count')
            ->groupBy('f.following')
            ->orderBy('follower_count', 'DESC')
            ->setMaxResults(5); // Obtener los primeros cinco resultados

        $query = $qb->getQuery();

        // Obtener los resultados
        return $query->getResult();
    }


    //    /**
    //     * @return Follower[] Returns an array of Follower objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Follower
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
