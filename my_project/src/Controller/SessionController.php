<?php

namespace App\Controller;

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
    private const REQUIRED_FIELDS_FOR_CREATE_SESSION = ['trainer_id', 'client_name', 'date', 'duration'];
    private const REQUIRED_FIELDS_FOR_UPDATE_SESSION = ['trainer_id', 'client_name', 'date', 'duration'];

    public function __construct(
        private readonly SessionService $sessionService,
        private readonly RequestCheckerService $requestCheckerService,
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[Route('', name: 'app_session_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->sessionService->getAllSessions(), Response::HTTP_OK);
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
