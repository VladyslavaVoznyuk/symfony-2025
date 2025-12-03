<?php

namespace App\EventListener;

use App\Entity\Payments;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Psr\Log\LoggerInterface;

class PaymentUpdateListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Спрацьовує після оновлення сутності Payments.
     */
    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if (!$entity instanceof Payments) {
            return;
        }

        $uow = $entityManager->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($entity);

        $logMessage = "AUDIT: Payment ID: {$entity->getId()} updated.";
        $changesDetected = false;

        foreach ($changeSet as $field => $changes) {

            if (in_array($field, ['amount', 'payment_date'])) {
                $oldValue = is_object($changes[0]) ? $changes[0]->format('Y-m-d') : $changes[0];
                $newValue = is_object($changes[1]) ? $changes[1]->format('Y-m-d') : $changes[1];

                $logMessage .= " Field '{$field}' changed from '{$oldValue}' to '{$newValue}'.";
                $changesDetected = true;
            }
        }

        if ($changesDetected) {
            $this->logger->warning($logMessage);
        }
    }
}