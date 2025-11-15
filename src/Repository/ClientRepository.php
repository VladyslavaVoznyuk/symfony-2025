<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     *
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllClientsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('client');

        // 1. Фільтрація: Універсальний пошук (search)
        if (!empty($data['search'])) {
            $searchTerm = '%' . $data['search'] . '%';
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('client.first_name', ':search'),
                    $queryBuilder->expr()->like('client.last_name', ':search'),
                    $queryBuilder->expr()->like('client.email', ':search')
                )
            )
                ->setParameter('search', $searchTerm);
        }

        if (!empty($data['birth_date_from'])) {
            $queryBuilder->andWhere('client.birth_date >= :date_from')
                ->setParameter('date_from', $data['birth_date_from']);
        }

        if (!empty($data['birth_date_to'])) {
            $queryBuilder->andWhere('client.birth_date <= :date_to')
                ->setParameter('date_to', $data['birth_date_to']);
        }

        $queryBuilder->orderBy('client.last_name', 'ASC');

        $paginator = new Paginator($queryBuilder->getQuery());
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * (max(1, $page) - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'clients' => $paginator->getQuery()->getResult(),
            'totalPageCount' => (int)$pagesCount,
            'totalItems' => $totalItems
        ];
    }
}