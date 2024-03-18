<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activity>
 *
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function search(?string $recherche): array
    {
        $qb = $this->getEntityManager()->getConnection();

        if (is_null($recherche)) {
            $sql = '
            SELECT a.id, animal_id, a.name as actiname, an.name as aniname, date, a.description, an.description as anidesd, nb_of_places, a.image_act FROM activity a
                     JOIN animal an on (a.animal_id = an.id)
            ORDER BY a.name ASC, date ASC
            ';
        } else {
            $sql = '
            SELECT a.id, animal_id, a.name as actiname, an.name as aniname, date, a.description, an.description as anidesd, nb_of_places, a.image_act FROM activity a
                     JOIN animal an on (a.animal_id = an.id)
                    WHERE an.name LIKE :animal
            ORDER BY a.name ASC, date ASC
            ';
        }
        $resultSet = $qb->executeQuery($sql, ['animal' => $recherche]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findForUser(User $user)
    {
        $qb = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT a.id, a.name as actiname FROM activity a
                JOIN booking b on (a.id = b.activity_id)
            WHERE b.user_id = :id
            ORDER BY a.name ASC, date ASC
            ';

        $resultSet = $qb->executeQuery($sql, ['id' => $user->getId()]);

        return $resultSet->fetchAllAssociative();
    }

    public function findByActivityId(Activity $activity)
    {
        $qb = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT an.id, an.name as name, an.description, an.image_ani FROM animal an
                JOIN activity ac ON (ac.animal_id = an.id)
            WHERE an.id = :id
            ';

        $resultSet = $qb->executeQuery($sql, ['id' => $activity->getAnimal()->getId()]);

        return $resultSet->fetchAllAssociative();
    }

    public function incrementsPlaces(Activity $activity)
    {
        $qb = $this->getEntityManager()->getConnection();

        $sql = '
            UPDATE activity
            SET nb_of_places = nb_of_places+1
            WHERE id = :id
            ';

        $resultSet = $qb->executeQuery($sql, ['id' => $activity->getId()]);
    }

    public function decrementsPlaces(Activity $activity)
    {
        $qb = $this->getEntityManager()->getConnection();

        $sql = '
            UPDATE activity
            SET nb_of_places = nb_of_places-1
            WHERE id = :id
            ';

        $resultSet = $qb->executeQuery($sql, ['id' => $activity->getId()]);
    }
    //    /**
    //     * @return Activity[] Returns an array of Activity objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Activity
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
