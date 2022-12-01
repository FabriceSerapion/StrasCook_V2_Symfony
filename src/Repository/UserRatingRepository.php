<?php

namespace App\Repository;

use App\Entity\UserRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserRating>
 *
 * @method UserRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserRating[]    findAll()
 * @method UserRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserRating::class);
    }

    public function save(UserRating $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserRating $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get all ratings for one menu from database by ID.
     */
    public function findAllRatingsByMenu(int $idMenu): array
   {
       return $this->createQueryBuilder('u')
       ->select('SUM(u.rating) as ratings')
       ->addSelect('COUNT(u.rating) as totalRatings')
       ->innerJoin('u.menu', 'm')
       ->where('m.id = :idMenu')
       ->setParameter('idMenu', $idMenu)
       ->getQuery()
       ->getResult()
       ;
   }

   public function findNoteFromMenuAndUser(int $idMenu, int $idCustomer): UserRating
   {
    return $this->createQueryBuilder('u')
    ->select('u.rating')
    ->innerJoin('u.menu', 'm')
    ->innerJoin('u.customer', 'c')
    ->where('m.id = :idMenu')
    ->setParameter('idMenu', $idMenu)
    ->where('c.id = :idCustomer')
    ->setParameter('idCustomer', $idCustomer)
    ->getQuery()
    ->getOneOrNullResult()
    ;
   }

//    /**
//     * @return UserRating[] Returns an array of UserRating objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserRating
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}