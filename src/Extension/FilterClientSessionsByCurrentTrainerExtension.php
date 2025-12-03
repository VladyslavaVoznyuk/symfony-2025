<?php
declare(strict_types=1);

namespace App\Extension;

use App\Entity\ClientSession;
use App\Entity\Trainers;
use App\Entity\Client;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

class FilterClientSessionsByCurrentTrainerExtension extends AbstractCurrentUserExtension
{
    protected function getResourceClass(): string
    {
        return ClientSession::class;
    }

    protected function buildQuery(QueryBuilder $queryBuilder, string $rootAlias): void
    {
        $user = $this->security->getUser();

        if (!$user instanceof Client) {
            return;
        }

        if (!$this->security->isGranted('ROLE_TRAINER')) {
            return;
        }


        $queryBuilder
            ->join("{$rootAlias}.session", 's')
            ->andWhere('s.trainer = :current_trainer_id')
            ->setParameter('current_trainer_id', $user->getId());
    }
}