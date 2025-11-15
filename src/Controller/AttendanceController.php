<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Repository\AttendanceRepository; // Додано
use App\Services\Attendance\AttendanceService;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Exception;

#[Route('/attendance')]
final class AttendanceController extends AbstractController
{
    private const ITEMS_PER_PAGE = 10;

    private EntityManagerInterface $entityManager;
    private AttendanceService $attendanceService;
    private RequestCheckerService $requestCheckerService;
    private AttendanceRepository $attendanceRepository; // Додано

    public function __construct(
        EntityManagerInterface $entityManager,
        AttendanceService $attendanceService,
        RequestCheckerService $requestCheckerService,
        AttendanceRepository $attendanceRepository // Ін'єкція репозиторію
    ) {
        $this->entityManager = $entityManager;
        $this->attendanceService = $attendanceService;
        $this->requestCheckerService = $requestCheckerService;
        $this->attendanceRepository = $attendanceRepository;
    }

    /**
     * @throws Exception
     */
    #[Route('', name: 'app_attendance_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->requestCheckerService->check($data, ['client', 'sessionDate', 'status']);

        $attendance = $this->attendanceService->createAttendance(
            $data['client'],
            $data['sessionDate'],
            $data['status']
        );

        $this->entityManager->flush();

        return new JsonResponse($attendance, Response::HTTP_CREATED);
    }

    #[Route('', name: 'app_attendance_get_collection', methods: ['GET'])]
    public function getCollection(Request $request): JsonResponse
    {
        $requestData = $request->query->all();

        $itemsPerPage = (int)($requestData['itemsPerPage'] ?? self::ITEMS_PER_PAGE);
        $page = (int)($requestData['page'] ?? 1);

        unset($requestData['itemsPerPage'], $requestData['page']);
        $filters = $requestData;

        $data = $this->attendanceRepository->getAllAttendanceByFilter(
            $filters,
            $itemsPerPage,
            $page
        );

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_attendance_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $attendance = $this->attendanceService->updateAttendance($id, $data);
        $this->entityManager->flush();

        return new JsonResponse($attendance, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_attendance_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->attendanceService->deleteAttendance($id);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}