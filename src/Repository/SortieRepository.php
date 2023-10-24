<?php

namespace App\Repository;


use App\DTO\SearchData;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $searchData, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $searchData, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findSearch(SearchData $searchData): array
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s', 'c', 'e')
            ->leftJoin('s.campus', 'c')
            ->leftJoin('s.etat', 'e');

        $this->applyFilters($qb, $searchData);

        return $qb->getQuery()->getResult();
    }

    private function applyFilters(QueryBuilder $qb, SearchData $searchData)
    {
        if (!empty($searchData->getCampus())) {
            $qb->andWhere('s.campus = :campus')
                ->setParameter('campus', $searchData->getCampus());
        }

        if (!empty($searchData->getKeyword())) {
            $qb->andWhere('s.nom LIKE :keyword')
                ->setParameter('keyword', '%' . $searchData->getKeyword() . '%');
        }

        if (!empty($searchData->getDateDebut())) {
            $qb->andWhere('s.dateHeureDebut >= :dateDebut')
                ->setParameter('dateDebut', $searchData->getDateDebut());
        }

        if (!empty($searchData->getDateFin())) {
            $qb->andWhere('s.dateHeureFin <= :dateFin')
                ->setParameter('dateFin', $searchData->getDateFin());
        }

        if ($searchData->isOrganisateur()) {
            $qb->andWhere('s.organisateur = :organisateur')
                ->setParameter('organisateur', $searchData->getOrganisateur());
        }

        if ($searchData->isInscrit()) {
            $qb->andWhere(':user MEMBER OF s.participants')
                ->setParameter('user', $searchData->getInscrit());
        }

        if ($searchData->isNonInscrit()) {
            $qb->andWhere(':user NOT MEMBER OF s.participants')
                ->setParameter('user', $searchData->getNonInscrit());
        }

        if ($searchData->isPassees()) {
            $qb->andWhere('s.dateHeureDebut < CURRENT_DATE()');
        }
    }
}
