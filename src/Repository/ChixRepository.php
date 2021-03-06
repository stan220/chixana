<?php

namespace App\Repository;

use App\Entity\Chix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @method Chix|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chix|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chix[]    findAll()
 * @method Chix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chix::class);
    }

    /**
     * @param int $id
     * @return Chix
     * @throws EntityNotFoundException
     */
    public function get(int $id): Chix
    {
        if (!$chix = $this->find($id)) {
            throw EntityNotFoundException::fromClassNameAndIdentifier($this->_entityName, [$id]);
        }

        return $chix;
    }

    /**
    * @return Chix[] Returns an array of Chix objects
    */
    public function findAllForToday(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.created_at >= :today')
            ->setParameter('today', date('Y-m-d'))
            ->orderBy('c.created_at', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $time
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getChixCountPerDay(int $time): int
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.created_at >= :from')
            ->andWhere('c.created_at <= :to')
            ->setParameter('from', date('Y-m-d 00:00:00', $time))
            ->setParameter('to', date('Y-m-d 23:59:59', $time))
            ->select('COUNT(c) as chixCount')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    // /**
    //  * @return Chix[] Returns an array of Chix objects
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

    /*
    public function findOneBySomeField($value): ?Chix
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
