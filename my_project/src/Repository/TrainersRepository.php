<?php

namespace App\Repository;

use App\Entity\Trainers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Trainers>
 */
class TrainersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trainers::class);
    }

    /**
     *
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllTrainersByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('t');

        if (!empty($data['search'])) {
            $searchTerm = '%' . $data['search'] . '%';
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('t.first_name', ':search'),
                    $queryBuilder->expr()->like('t.last_name', ':search'),
                    $queryBuilder->expr()->like('t.email', ':search')
                )
            )
                ->setParameter('search', $searchTerm);
        }
        if (!empty($data['specialty'])) {
            $queryBuilder->andWhere('t.specialty = :specialty')
                ->setParameter('specialty', $data['specialty']);
        }

        $queryBuilder->orderBy('t.last_name', 'ASC');

        $paginator = new Paginator($queryBuilder->getQuery());
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * (max(1, $page) - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'trainers' => $paginator->getQuery()->getResult(),
            'totalPageCount' => (int)$pagesCount,
            'totalItems' => $totalItems
        ];
    }
}