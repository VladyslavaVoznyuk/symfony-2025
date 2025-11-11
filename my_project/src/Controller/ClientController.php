<?php

namespace App\Controller;

use App\Service\ClientService;
use App\Service\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Exception;

#[Route('/api/clients')]
class ClientController extends AbstractController
{
    public const REQUIRED_FIELDS_FOR_CREATE = ['firstName', 'lastName', 'email', 'phone'];

    private ClientService $clientService;
    private RequestCheckerService $requestCheckerService;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ClientService $clientService,
        RequestCheckerService $requestCheckerService,
        EntityManagerInterface $entityManager
    ) {
        $this->clientService = $clientService;
        $this->requestCheckerService = $requestCheckerService;
        $this->entityManager = $entityManager;
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, self::REQUIRED_FIELDS_FOR_CREATE);

        $client = $this->clientService->createClient(
            $data['firstName'],
            $data['lastName'],
            $data['email'],
            $data['phone']
        );

        $this->entityManager->flush();
        return new JsonResponse($client, Response::HTTP_CREATED);
    }

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $clients = $this->clientService->getAllClients();
        return new JsonResponse($clients, Response::HTTP_OK);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $client = $this->clientService->getClientById($id);
        if (!$client) {
            return new JsonResponse(['error' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($client, Response::HTTP_OK);
    }

    #[Route('/{id}', methods: ['PUT'])]
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
