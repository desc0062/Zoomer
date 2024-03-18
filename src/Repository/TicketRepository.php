<?php

namespace App\Repository;

use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 *
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

//    /**
//     * @return Ticket[] Returns an array of Ticket objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ticket
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function countTicketsByUser(User $user): int
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.userConcerned = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countTicketsByAdmin(User $user): int
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.adminConcerned = :adminId')
            ->setParameter('adminId', $user->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findTicketsByUserId(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.userConcerned = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function findTicketsByAdminId(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.adminConcerned = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }
}
