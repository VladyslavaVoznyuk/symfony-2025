<?php

namespace App\EventListener;

use App\Entity\Trainers;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Psr\Log\LoggerInterface;

class TrainerUpdateListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Спрацьовує після оновлення сутності Trainers.
     */
    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if (!$entity instanceof Trainers) {
            return;
        }

        $uow = $entityManager->getUnitOfWork();

        $changeSet = $uow->getEntityChangeSet($entity);

        $logMessage = "Trainer ID: {$entity->getId()} updated. Changes:";

        foreach ($changeSet as $field => $changes) {
            $oldValue = $changes[0];
            $newValue = $changes[1];

            if (in_array($field, ['phone', 'specialty'])) {
                $logMessage .= " Field '{$field}' changed from '{$oldValue}' to '{$newValue}'.";
            }
        }

        $this->logger->info($logMessage);

    }
}