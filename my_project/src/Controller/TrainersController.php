<?php

namespace App\Controller;

use App\Entity\Trainers;
use App\Repository\TrainersRepository; // Додано
use App\Service\RequestCheckerService;
use App\Service\TrainerService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/trainers')]
final class TrainersController extends AbstractController
{
    private const ITEMS_PER_PAGE = 15;
    private const REQUIRED_FIELDS_FOR_CREATE_TRAINER = ['name', 'specialization', 'experience', 'phone'];
    private const REQUIRED_FIELDS_FOR_UPDATE_TRAINER = ['name', 'specialization', 'experience', 'phone'];

    private readonly TrainerService $trainerService;
    private readonly RequestCheckerService $requestCheckerService;
    private readonly EntityManagerInterface $entityManager;
    private readonly TrainersRepository $trainersRepository;

    public function __construct(
        TrainerService $trainerService,
        RequestCheckerService $requestCheckerService,
        EntityManagerInterface $entityManager,
        TrainersRepository $trainersRepository
    ) {
        $this->trainerService = $trainerService;
        $this->requestCheckerService = $requestCheckerService;
        $this->entityManager = $entityManager;
        $this->trainersRepository = $trainersRepository;
    }

    #[Route('', name: 'app_trainers_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $requestData = $request->query->all();

        $itemsPerPage = (int)($requestData['itemsPerPage'] ?? self::ITEMS_PER_PAGE);
        $page = (int)($requestData['page'] ?? 1);

        unset($requestData['itemsPerPage'], $requestData['page']);
        $filters = $requestData;

        $trainersData = $this->trainersRepository->getAllTrainersByFilter(
            $filters,
            $itemsPerPage,
            $page
        );

        return new JsonResponse($trainersData, Response::HTTP_OK);
    }


    #[Route('', name: 'app_trainers_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($requestData, self::REQUIRED_FIELDS_FOR_CREATE_TRAINER);

        $trainer = $this->trainerService->createTrainer(
            $requestData['name'],
            $requestData['specialization'],
            $requestData['experience'],
            $requestData['phone']
        );

        $this->entityManager->flush();
        return new JsonResponse($trainer, Response::HTTP_CREATED);
    }


    #[Route('/{id}', name: 'app_trainers_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $trainer = $this->trainerService->getTrainerById($id);

        if (!$trainer) {
            return new JsonResponse(['error' => 'Trainer not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($trainer, Response::HTTP_OK);
    }


    #[Route('/{id}', name: 'app_trainers_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($requestData, self::REQUIRED_FIELDS_FOR_UPDATE_TRAINER);

        $trainer = $this->trainerService->updateTrainer(
            $id,
            $requestData['name'],
            $requestData['specialization'],
            $requestData['experience'],
            $requestData['phone']
        );

        if (!$trainer) {
            return new JsonResponse(['error' => 'Trainer not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
        return new JsonResponse($trainer, Response::HTTP_OK);
    }


    #[Route('/{id}', name: 'app_trainers_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $deleted = $this->trainerService->deleteTrainer($id);

        if (!$deleted) {
            return new JsonResponse(['error' => 'Trainer not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
        return new JsonResponse(['message' => 'Trainer deleted successfully'], Response::HTTP_OK);
    }
}