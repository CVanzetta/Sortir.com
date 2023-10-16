<?php

namespace App\Repository;

use App\Entity\Panticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Panticipant>
 *
 * @method Panticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panticipant[]    findAll()
 * @method Panticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panticipant::class);
    }

//    /**
//     * @return Panticipant[] Returns an array of Panticipant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Panticipant
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
