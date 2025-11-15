<?php

namespace App\Repository;

use App\Entity\ClientSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<ClientSession>
 */
class ClientSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientSession::class);
    }

    /**
     *
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllClientSessionsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('cs');

        $queryBuilder->leftJoin('cs.client', 'client')
            ->addSelect('client')
            ->leftJoin('cs.session', 'session')
            ->addSelect('session');

        if (!empty($data['client_id'])) {
            $queryBuilder->andWhere('client.id = :clientId')
                ->setParameter('clientId', $data['client_id']);
        }

        if (!empty($data['session_id'])) {
            $queryBuilder->andWhere('session.id = :sessionId')
                ->setParameter('sessionId', $data['session_id']);
        }

        $queryBuilder->orderBy('cs.id', 'DESC');

        $paginator = new Paginator($queryBuilder->getQuery());
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * (max(1, $page) - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'clientSessions' => $paginator->getQuery()->getResult(),
            'totalPageCount' => (int)$pagesCount,
            'totalItems' => $totalItems
        ];
    }
}