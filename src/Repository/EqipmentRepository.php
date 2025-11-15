<?php

namespace App\Repository;

use App\Entity\Eqipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Eqipment>
 */
class EqipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eqipment::class);
    }

    /**
     *
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllEqipmentsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('e');

        // 1. Фільтрація: Універсальний пошук (за назвою)
        if (!empty($data['search'])) {
            $searchTerm = '%' . $data['search'] . '%';
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('e.name', ':search'),
                    $queryBuilder->expr()->like('e.description', ':search')
                )
            )
                ->setParameter('search', $searchTerm);
        }

        if (!empty($data['type'])) {
            $queryBuilder->andWhere('e.type = :type')
                ->setParameter('type', $data['type']);
        }

        if (!empty($data['condition'])) {
            $queryBuilder->andWhere('e.condition = :condition')
                ->setParameter('condition', $data['condition']);
        }

        $queryBuilder->orderBy('e.name', 'ASC');

        $paginator = new Paginator($queryBuilder->getQuery());
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * (max(1, $page) - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'eqipments' => $paginator->getQuery()->getResult(),
            'totalPageCount' => (int)$pagesCount,
            'totalItems' => $totalItems
        ];
    }
}