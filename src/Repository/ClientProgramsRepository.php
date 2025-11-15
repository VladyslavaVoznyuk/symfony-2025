<?php

namespace App\Repository;

use App\Entity\ClientPrograms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<ClientPrograms>
 */
class ClientProgramsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientPrograms::class);
    }

    /**
     *
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllClientProgramsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('cp');

        $queryBuilder->leftJoin('cp.client', 'client')
            ->addSelect('client')
            ->leftJoin('cp.program', 'program')
            ->addSelect('program');

        if (!empty($data['client_id'])) {
            $queryBuilder->andWhere('client.id = :clientId')
                ->setParameter('clientId', $data['client_id']);
        }

        if (!empty($data['program_id'])) {
            $queryBuilder->andWhere('program.id = :programId')
                ->setParameter('programId', $data['program_id']);
        }

        if (!empty($data['start_date_from'])) {
            $queryBuilder->andWhere('cp.start_date >= :startDateFrom')
                ->setParameter('startDateFrom', $data['start_date_from']);
        }

        if (!empty($data['end_date_to'])) {
            $queryBuilder->andWhere('cp.end_date <= :endDateTo')
                ->setParameter('endDateTo', $data['end_date_to']);
        }

        $queryBuilder->orderBy('cp.start_date', 'DESC');

        $paginator = new Paginator($queryBuilder->getQuery());
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * (max(1, $page) - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'clientPrograms' => $paginator->getQuery()->getResult(),
            'totalPageCount' => (int)$pagesCount,
            'totalItems' => $totalItems
        ];
    }
}