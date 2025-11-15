<?php

namespace App\Controller;

use App\Repository\ClientSessionRepository; // Додано
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
    private const ITEMS_PER_PAGE = 20;

    private EntityManagerInterface $entityManager;
    private ClientSessionService $clientSessionService;
    private RequestCheckerService $requestCheckerService;
    private ClientSessionRepository $clientSessionRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ClientSessionService $clientSessionService,
        RequestCheckerService $requestCheckerService,
        ClientSessionRepository $clientSessionRepository
    ) {
        $this->entityManager = $entityManager;
        $this->clientSessionService = $clientSessionService;
        $this->requestCheckerService = $requestCheckerService;
        $this->clientSessionRepository = $clientSessionRepository;
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
    public function index(Request $request): JsonResponse
    {
        $requestData = $request->query->all();

        $itemsPerPage = (int)($requestData['itemsPerPage'] ?? self::ITEMS_PER_PAGE);
        $page = (int)($requestData['page'] ?? 1);

        unset($requestData['itemsPerPage'], $requestData['page']);
        $filters = $requestData;

        $clientSessionsData = $this->clientSessionRepository->getAllClientSessionsByFilter(
            $filters,
            $itemsPerPage,
            $page
        );

        return new JsonResponse($clientSessionsData, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_client_session_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $session = $this->clientSessionService->updateClientSession($id, $data);
        $this->entityManager->flush();

        return new JsonResponse($session, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_client_session_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->clientSessionService->deleteClientSession($id);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}