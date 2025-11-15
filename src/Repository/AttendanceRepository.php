<?php

namespace App\Repository;

use App\Entity\Attendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Attendance>
 */
class AttendanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attendance::class);
    }

    /**
     *
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllAttendanceByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $queryBuilder->leftJoin('a.client', 'client')
            ->addSelect('client')
            ->leftJoin('a.session', 'session')
            ->addSelect('session');

        if (!empty($data['client_id'])) {
            $queryBuilder->andWhere('client.id = :clientId')
                ->setParameter('clientId', $data['client_id']);
        }

        if (!empty($data['session_id'])) {
            $queryBuilder->andWhere('session.id = :sessionId')
                ->setParameter('sessionId', $data['session_id']);
        }

        if (!empty($data['attended']) && in_array($data['attended'], ['yes', 'no'])) {
            $queryBuilder->andWhere('a.attended = :attendedStatus')
                ->setParameter('attendedStatus', $data['attended']);
        }

        $queryBuilder->orderBy('a.id', 'DESC');

        $paginator = new Paginator($queryBuilder->getQuery());
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * (max(1, $page) - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'attendances' => $paginator->getQuery()->getResult(),
            'totalPageCount' => (int)$pagesCount,
            'totalItems' => $totalItems
        ];
    }
}