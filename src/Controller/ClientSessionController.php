<?php

namespace App\Controller;

use App\Services\ClientSession\ClientSessionService;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Exception;

#[Route('/client/session')]
final class ClientSessionController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ClientSessionService $clientSessionService;
    private RequestCheckerService $requestCheckerService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ClientSessionService $clientSessionService,
        RequestCheckerService $requestCheckerService
    ) {
        $this->entityManager = $entityManager;
        $this->clientSessionService = $clientSessionService;
        $this->requestCheckerService = $requestCheckerService;
    }

    /**
     * @throws Exception
     */
    #[Route('', name: 'app_client_session_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, ['client', 'sessionDate', 'trainer']);

        $session = $this->clientSessionService->createClientSession(
            $data['client'],
            $data['sessionDate'],
            $data['trainer']
        );

        $this->entityManager->flush();

        return new JsonResponse($session, Response::HTTP_CREATED);
    }

    #[Route('', name: 'app_client_session_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->clientSessionService->getAll());
    }

    #[Route('/{id}', name: 'app_client_session_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $session = $this->clientSessionService->updateClientSession($id, $data);
        $this->entityManager->flush();

        return new JsonResponse($session);
    }

    #[Route('/{id}', name: 'app_client_session_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->clientSessionService->deleteClientSession($id);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
