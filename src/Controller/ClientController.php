<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Services\Client\ClientService;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// 💡 Необхідний імпорт

#[Route('/api/clients')]
class ClientController extends AbstractController
{
    private const ITEMS_PER_PAGE = 20;
    public const REQUIRED_FIELDS_FOR_CREATE = ['firstName', 'lastName', 'email', 'phone', 'password'];

    private ClientService $clientService;
    private RequestCheckerService $requestCheckerService;
    private EntityManagerInterface $entityManager;
    private ClientRepository $clientRepository;

    public function __construct(
        ClientService $clientService,
        RequestCheckerService $requestCheckerService,
        EntityManagerInterface $entityManager,
        ClientRepository $clientRepository
    ) {
        $this->clientService = $clientService;
        $this->requestCheckerService = $requestCheckerService;
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
    }

    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, self::REQUIRED_FIELDS_FOR_CREATE);

        $client = $this->clientService->createClient(
            $data['firstName'],
            $data['lastName'],
            $data['email'],
            $data['phone'],
            $data['password']
        );

        $this->entityManager->flush();
        return new JsonResponse($client, Response::HTTP_CREATED);
    }

    #[Route('', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request): JsonResponse
    {
        $requestData = $request->query->all();

        $itemsPerPage = (int)($requestData['itemsPerPage'] ?? self::ITEMS_PER_PAGE);
        $page = (int)($requestData['page'] ?? 1);

        unset($requestData['itemsPerPage'], $requestData['page']);
        $filters = $requestData;

        $clientsData = $this->clientRepository->getAllClientsByFilter(
            $filters,
            $itemsPerPage,
            $page
        );

        return new JsonResponse($clientsData, Response::HTTP_OK);
    }

    #[Route('/{id}', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(int $id): JsonResponse
    {
        $client = $this->clientService->getClientById($id);
        if (!$client) {
            return new JsonResponse(['error' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($client, Response::HTTP_OK);
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN')]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $client = $this->clientService->updateClient($id, $data);
        if (!$client) {
            return new JsonResponse(['error' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->flush();
        return new JsonResponse($client, Response::HTTP_OK);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id): JsonResponse
    {
        $deleted = $this->clientService->deleteClient($id);
        if (!$deleted) {
            return new JsonResponse(['error' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}