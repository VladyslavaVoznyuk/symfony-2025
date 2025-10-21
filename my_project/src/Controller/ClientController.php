<?php

namespace App\Controller;

use App\Entity\Client;
use App\Service\ClientService;
use App\Service\ValidatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/clients')]
class ClientController extends AbstractController
{
    private ClientService $clientService;
    private ValidatorService $validator;

    public function __construct(ClientService $clientService, ValidatorService $validator)
    {
        $this->clientService = $clientService;
        $this->validator = $validator;
    }

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $clients = $this->clientService->getAll();
        return $this->json($clients);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $errors = $this->validator->validateClientData($data);
        if ($errors) {
            return $this->json(['errors' => $errors], 400);
        }

        $client = $this->clientService->create($data);
        return $this->json($client, 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $errors = $this->validator->validateClientData($data, false);
        if ($errors) {
            return $this->json(['errors' => $errors], 400);
        }

        $client = $this->clientService->update($id, $data);
        if (!$client) {
            return $this->json(['error' => 'Client not found'], 404);
        }

        return $this->json($client);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $deleted = $this->clientService->delete($id);
        if (!$deleted) {
            return $this->json(['error' => 'Client not found'], 404);
        }

        return $this->json(null, 204);
    }
}
