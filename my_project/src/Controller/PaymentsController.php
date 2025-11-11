<?php

namespace App\Controller;

use App\Service\RequestCheckerService;
use App\Service\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/payments')]
final class PaymentsController extends AbstractController
{
    private const REQUIRED_FIELDS_FOR_CREATE_PAYMENT = ['client_name', 'amount', 'method', 'date'];
    private const REQUIRED_FIELDS_FOR_UPDATE_PAYMENT = ['client_name', 'amount', 'method', 'date'];

    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly RequestCheckerService $requestCheckerService,
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[Route('', name: 'app_payments_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->paymentService->getAllPayments(), Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('', name: 'app_payments_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, self::REQUIRED_FIELDS_FOR_CREATE_PAYMENT);

        $payment = $this->paymentService->createPayment(
            $data['client_name'],
            $data['amount'],
            $data['method'],
            $data['date']
        );

        $this->entityManager->flush();
        return new JsonResponse($payment, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_payments_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $payment = $this->paymentService->getPaymentById($id);
        if (!$payment) {
            return new JsonResponse(['error' => 'Payment not found'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($payment, Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}', name: 'app_payments_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, self::REQUIRED_FIELDS_FOR_UPDATE_PAYMENT);

        $payment = $this->paymentService->updatePayment(
            $id,
            $data['client_name'],
            $data['amount'],
            $data['method'],
            $data['date']
        );

        if (!$payment) {
            return new JsonResponse(['error' => 'Payment not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
        return new JsonResponse($payment, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_payments_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $deleted = $this->paymentService->deletePayment($id);

        if (!$deleted) {
            return new JsonResponse(['error' => 'Payment not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
        return new JsonResponse(['message' => 'Payment deleted successfully'], Response::HTTP_OK);
    }
}
