<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Booking;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function addUser(User $user)
    {
        // todo
    }


    public function getInscrit(Activity $activity): array
    {
        $qb = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT b.id, u.id, u.last_name, u.first_name FROM booking b
                    JOIN user u ON (b.user_id = u.id)
                    WHERE activity_id = :id
            ORDER BY u.last_name ASC
            ';

        $resultSet = $qb->executeQuery($sql, ['id' => $activity->getId()]);

        return $resultSet->fetchAllAssociative();
    }

    public function getIdInscrit(Activity $activity)
    {
        $qb = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT u.id FROM booking b
                    JOIN user u ON (b.user_id = u.id)
                    WHERE activity_id = :id
            ORDER BY u.last_name ASC
            ';

        $resultSet = $qb->executeQuery($sql, ['id' => $activity->getId()]);

        return $resultSet->fetchFirstColumn();
    }

    //    /**
    //     * @return Booking[] Returns an array of Booking objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Booking
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
