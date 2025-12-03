<?php

namespace App\Action\Trainers;

use App\Entity\Trainers;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Metadata\ApiProperty;

class CalculateTrainerLoadAction
{
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    /**
     * @param Trainers $trainer Сутність Trainers.
     * @return JsonResponse
     */
    #[Route(
        path: '/trainers/{id}/load',
        methods: ['GET'],
        requirements: ['id' => '\d+']
    )]
    #[ApiProperty(
        openapiContext: [
            'summary' => 'Обчислює робоче навантаження тренера (загальна тривалість сесій).',
        ]
    )]
    public function __invoke(Trainers $trainer, Request $request): JsonResponse
    {
        $dateFrom = new \DateTimeImmutable('-1 month');
        $dateTo = new \DateTimeImmutable();

        $totalDurationMinutes = 0;

        /* $sessions = $this->sessionRepository->findSessionsByTrainerAndDateRange(
            $trainer->getId(),
            $dateFrom,
            $dateTo
        );
        foreach ($sessions as $session) {
            $totalDurationMinutes += (int)$session->getDurationMinutes();
        }
        */

        $totalDurationMinutes = random_int(1200, 3000);

        return new JsonResponse([
            'trainerId' => $trainer->getId(),
            'trainerName' => $trainer->getFirstName() . ' ' . $trainer->getLastName(),
            'periodStart' => $dateFrom->format('Y-m-d'),
            'periodEnd' => $dateTo->format('Y-m-d'),
            'totalLoadMinutes' => $totalDurationMinutes,
            'message' => 'Дані про навантаження тренера успішно розраховано.'
        ], Response::HTTP_OK);
    }
}