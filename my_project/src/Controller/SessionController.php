<?php

namespace App\Controller;

use App\Repository\SessionRepository; // Додано
use App\Service\RequestCheckerService;
use App\Service\SessionService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/sessions')]
final class SessionController extends AbstractController
{
    private const ITEMS_PER_PAGE = 20;
    private const REQUIRED_FIELDS_FOR_CREATE_SESSION = ['trainer_id', 'client_name', 'date', 'duration'];
    private const REQUIRED_FIELDS_FOR_UPDATE_SESSION = ['trainer_id', 'client_name', 'date', 'duration'];

    private readonly SessionService $sessionService;
    private readonly RequestCheckerService $requestCheckerService;
    private readonly EntityManagerInterface $entityManager;
    private readonly SessionRepository $sessionRepository;

    public function __construct(
        SessionService $sessionService,
        RequestCheckerService $requestCheckerService,
        EntityManagerInterface $entityManager,
        SessionRepository $sessionRepository
    ) {
        $this->sessionService = $sessionService;
        $this->requestCheckerService = $requestCheckerService;
        $this->entityManager = $entityManager;
        $this->sessionRepository = $sessionRepository;
    }

    #[Route('', name: 'app_session_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $requestData = $request->query->all();

        $itemsPerPage = (int)($requestData['itemsPerPage'] ?? self::ITEMS_PER_PAGE);
        $page = (int)($requestData['page'] ?? 1);

        unset($requestData['itemsPerPage'], $requestData['page']);
        $filters = $requestData;

        $sessionsData = $this->sessionRepository->getAllSessionsByFilter(
            $filters,
            $itemsPerPage,
            $page
        );

        return new JsonResponse($sessionsData, Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('', name: 'app_session_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, self::REQUIRED_FIELDS_FOR_CREATE_SESSION);

        $session = $this->sessionService->createSession(
            $data['trainer_id'],
            $data['client_name'],
            $data['date'],
            $data['duration']
        );

        $this->entityManager->flush();
        return new JsonResponse($session, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $session = $this->sessionService->getSessionById($id);
        if (!$session) {
            return new JsonResponse(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($session, Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}', name: 'app_session_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, self::REQUIRED_FIELDS_FOR_UPDATE_SESSION);

        $session = $this->sessionService->updateSession(
            $id,
            $data['trainer_id'],
            $data['client_name'],
            $data['date'],
            $data['duration']
        );

        if (!$session) {
            return new JsonResponse(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
        return new JsonResponse($session, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_session_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $deleted = $this->sessionService->deleteSession($id);

        if (!$deleted) {
            return new JsonResponse(['error' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
        return new JsonResponse(['message' => 'Session deleted successfully'], Response::HTTP_OK);
    }
}