<?php

namespace App\Controller;

use App\Service\RequestCheckerService;
use App\Service\EqipmentService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/eqipments')]
final class EqipmentController extends AbstractController
{
    private const REQUIRED_FIELDS_FOR_CREATE_EQIPMENT = ['name', 'type', 'condition', 'quantity'];
    private const REQUIRED_FIELDS_FOR_UPDATE_EQIPMENT = ['name', 'type', 'condition', 'quantity'];

    public function __construct(
        private readonly EqipmentService $eqipmentService,
        private readonly RequestCheckerService $requestCheckerService,
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[Route('', name: 'app_eqipment_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->eqipmentService->getAllEqipments(), Response::HTTP_OK);
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
