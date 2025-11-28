<?php

namespace App\Controller;

use App\Repository\ClientProgramsRepository;
use App\Services\ClientPrograms\ClientProgramsService;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted; // 💡 Необхідний імпорт
use Exception;
#[Route('/api/client/programs')]
final class ClientProgramsController extends AbstractController
{
    private const ITEMS_PER_PAGE = 15;

    private EntityManagerInterface $entityManager;
    private ClientProgramsService $clientProgramsService;
    private RequestCheckerService $requestCheckerService;
    private ClientProgramsRepository $clientProgramsRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ClientProgramsService $clientProgramsService,
        RequestCheckerService $requestCheckerService,
        ClientProgramsRepository $clientProgramsRepository
    ) {
        $this->entityManager = $entityManager;
        $this->clientProgramsService = $clientProgramsService;
        $this->requestCheckerService = $requestCheckerService;
        $this->clientProgramsRepository = $clientProgramsRepository;
    }

    /**
     * @throws Exception
     */
    #[Route('', name: 'app_client_programs_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
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
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): JsonResponse
    {
        $requestData = $request->query->all();

        $itemsPerPage = (int)($requestData['itemsPerPage'] ?? self::ITEMS_PER_PAGE);
        $page = (int)($requestData['page'] ?? 1);

        unset($requestData['itemsPerPage'], $requestData['page']);
        $filters = $requestData;

        $clientProgramsData = $this->clientProgramsRepository->getAllClientProgramsByFilter(
            $filters,
            $itemsPerPage,
            $page
        );

        return new JsonResponse($clientProgramsData, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_client_programs_update', methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN')]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $program = $this->clientProgramsService->updateClientProgram($id, $data);
        $this->entityManager->flush();

        return new JsonResponse($program, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_client_programs_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id): JsonResponse
    {
        $this->clientProgramsService->deleteClientProgram($id);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}