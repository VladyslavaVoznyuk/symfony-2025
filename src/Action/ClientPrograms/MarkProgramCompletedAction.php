<?php

namespace App\Action\ClientPrograms;

use App\Entity\ClientPrograms;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class MarkProgramCompletedAction
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ClientPrograms $clientProgram Сутність ClientPrograms.
     * @return ClientPrograms
     */
    public function __invoke(ClientPrograms $clientProgram): ClientPrograms
    {
        $today = new \DateTimeImmutable();

        if ($clientProgram->getEndDate() <= $today) {
            throw new RuntimeException(
                'Ця програма клієнта вже завершена.',
                Response::HTTP_BAD_REQUEST
            );
        }

        $clientProgram->setEndDate($today);


        return $clientProgram;
    }
}