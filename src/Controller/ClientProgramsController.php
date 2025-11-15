<?php

namespace App\Controller;

use App\Services\ClientPrograms\ClientProgramsService;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Exception;

#[Route('/client/programs')]
final class ClientProgramsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ClientProgramsService $clientProgramsService;
    private RequestCheckerService $requestCheckerService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ClientProgramsService $clientProgramsService,
        RequestCheckerService $requestCheckerService
    ) {
        $this->entityManager = $entityManager;
        $this->clientProgramsService = $clientProgramsService;
        $this->requestCheckerService = $requestCheckerService;
    }

    /**
     * @throws Exception
     */
    #[Route('', name: 'app_client_programs_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, ['client', 'program', 'startDate', 'endDate']);

        $program = $this->clientProgramsService->createClientProgram(
            $data['client'],
            $data['program'],
            $data['startDate'],
            $data['endDate']
        );

        $this->entityManager->flush();

        return new JsonResponse($program, Response::HTTP_CREATED);
    }

    #[Route('', name: 'app_client_programs_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->clientProgramsService->getAll());
    }

    #[Route('/{id}', name: 'app_client_programs_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $program = $this->clientProgramsService->updateClientProgram($id, $data);
        $this->entityManager->flush();

        return new JsonResponse($program);
    }

    #[Route('/{id}', name: 'app_client_programs_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->clientProgramsService->deleteClientProgram($id);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
