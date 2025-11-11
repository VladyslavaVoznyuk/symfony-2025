<?php

namespace App\Repository;

use App\Entity\Payments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Payments>
 */
class PaymentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payments::class);
    }

    /**
     *
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllPaymentsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder->leftJoin('p.client', 'client')
            ->addSelect('client');

        if (!empty($data['client_id'])) {
            $queryBuilder->andWhere('client.id = :clientId')
                ->setParameter('clientId', $data['client_id']);
        }

        if (!empty($data['amount_min'])) {
            $queryBuilder->andWhere('p.amount >= :amountMin')
                ->setParameter('amountMin', $data['amount_min']);
        }

        if (!empty($data['amount_max'])) {
            $queryBuilder->andWhere('p.amount <= :amountMax')
                ->setParameter('amountMax', $data['amount_max']);
        }

        if (!empty($data['date_from'])) {
            $queryBuilder->andWhere('p.payment_date >= :dateFrom')
                ->setParameter('dateFrom', $data['date_from']);
        }

        if (!empty($data['date_to'])) {
            $queryBuilder->andWhere('p.payment_date <= :dateTo')
                ->setParameter('dateTo', $data['date_to']);
        }

        $queryBuilder->orderBy('p.payment_date', 'DESC');

        $paginator = new Paginator($queryBuilder->getQuery());
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * (max(1, $page) - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'payments' => $paginator->getQuery()->getResult(),
            'totalPageCount' => (int)$pagesCount,
            'totalItems' => $totalItems
        ];
    }
}