<?php

namespace App\Repository;

use App\Entity\Cook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cook>
 *
 * @method Cook|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cook|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cook[]    findAll()
 * @method Cook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cook::class);
    }

    public function save(Cook $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cook $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * Get all row from database.
     */
    public function findOneByHour(int $hour): Cook|null
    {
        return $this->createQueryBuilder('c')
            ->where('c.shift_start <= :hour')
            ->andWhere('c.shift_end > :hour')
            ->setParameter('hour', $hour)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
    ;
    }
    //    /**
//     * @return Cook[] Returns an array of Cook objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cook
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
