<?php

namespace App\Controller;

use App\Repository\EqipmentRepository;
use App\Services\Eqipment\EqipmentService;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Додано

#[Route('/api/eqipments')]
final class EqipmentController extends AbstractController
{
    private const ITEMS_PER_PAGE = 20; // Константа для пагінації
    private const REQUIRED_FIELDS_FOR_CREATE_EQIPMENT = ['name', 'type', 'condition', 'quantity'];
    private const REQUIRED_FIELDS_FOR_UPDATE_EQIPMENT = ['name', 'type', 'condition', 'quantity'];

    private readonly EqipmentService $eqipmentService;
    private readonly RequestCheckerService $requestCheckerService;
    private readonly EntityManagerInterface $entityManager;
    private readonly EqipmentRepository $eqipmentRepository; // Додано

    public function __construct(
        EqipmentService $eqipmentService,
        RequestCheckerService $requestCheckerService,
        EntityManagerInterface $entityManager,
        EqipmentRepository $eqipmentRepository
    ) {
        $this->eqipmentService = $eqipmentService;
        $this->requestCheckerService = $requestCheckerService;
        $this->entityManager = $entityManager;
        $this->eqipmentRepository = $eqipmentRepository;
    }

    #[Route('', name: 'app_eqipment_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $requestData = $request->query->all();

        $itemsPerPage = (int)($requestData['itemsPerPage'] ?? self::ITEMS_PER_PAGE);
        $page = (int)($requestData['page'] ?? 1);

        unset($requestData['itemsPerPage'], $requestData['page']);
        $filters = $requestData;

        $eqipmentsData = $this->eqipmentRepository->getAllEqipmentsByFilter(
            $filters,
            $itemsPerPage,
            $page
        );

        return new JsonResponse($eqipmentsData, Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('', name: 'app_eqipment_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, self::REQUIRED_FIELDS_FOR_CREATE_EQIPMENT);

        $eqipment = $this->eqipmentService->createEqipment(
            $data['name'],
            $data['type'],
            $data['condition'],
            $data['quantity']
        );

        $this->entityManager->flush();
        return new JsonResponse($eqipment, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_eqipment_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $eqipment = $this->eqipmentService->getEqipmentById($id);
        if (!$eqipment) {
            return new JsonResponse(['error' => 'Equipment not found'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($eqipment, Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}', name: 'app_eqipment_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, self::REQUIRED_FIELDS_FOR_UPDATE_EQIPMENT);

        $eqipment = $this->eqipmentService->updateEqipment(
            $id,
            $data['name'],
            $data['type'],
            $data['condition'],
            $data['quantity']
        );

        if (!$eqipment) {
            return new JsonResponse(['error' => 'Equipment not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
        return new JsonResponse($eqipment, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_eqipment_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $deleted = $this->eqipmentService->deleteEqipment($id);

        if (!$deleted) {
            return new JsonResponse(['error' => 'Equipment not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
        return new JsonResponse(['message' => 'Equipment deleted successfully'], Response::HTTP_OK);
    }
}