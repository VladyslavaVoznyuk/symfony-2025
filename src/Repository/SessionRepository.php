<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     *
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllSessionsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder->leftJoin('s.trainer', 't')
            ->addSelect('t')
            ->leftJoin('s.program', 'p')
            ->addSelect('p');

        if (!empty($data['trainer_id'])) {
            $queryBuilder->andWhere('t.id = :trainerId')
                ->setParameter('trainerId', $data['trainer_id']);
        }

        if (!empty($data['program_id'])) {
            $queryBuilder->andWhere('p.id = :programId')
                ->setParameter('programId', $data['program_id']);
        }

        if (!empty($data['date_from'])) {
            $queryBuilder->andWhere('s.session_date >= :dateFrom')
                ->setParameter('dateFrom', $data['date_from']);
        }

        if (!empty($data['date_to'])) {
            $queryBuilder->andWhere('s.session_date <= :dateTo')
                ->setParameter('dateTo', $data['date_to']);
        }

        $queryBuilder->orderBy('s.session_date', 'DESC');

        $paginator = new Paginator($queryBuilder->getQuery());
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * (max(1, $page) - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'sessions' => $paginator->getQuery()->getResult(),
            'totalPageCount' => (int)$pagesCount,
            'totalItems' => $totalItems
        ];
    }
}