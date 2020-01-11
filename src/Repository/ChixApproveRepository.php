<?php

namespace App\Repository;

use App\Entity\ChixApprove;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ChixApprove|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChixApprove|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChixApprove[]    findAll()
 * @method ChixApprove[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChixApproveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChixApprove::class);
    }

    /**
     * @param int $count
     * @return ChixApprove[] Returns an array of ChixApprove objects
     */
    public function findLast(int $count = 10): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.created_at', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByUserAndChix(int $userId, int $chixId): ?ChixApprove
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :userId')
            ->andWhere('c.chix = :chixId')
            ->setParameter('userId', $userId)
            ->setParameter('chixId', $chixId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return ChixApprove[] Returns an array of ChixApprove objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
