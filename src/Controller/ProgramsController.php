<?php

namespace App\Controller;

use App\Entity\Programs;
use App\Repository\ProgramsRepository;
use App\Service\ProgramService;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programs')]
final class ProgramsController extends AbstractController
{
    public function __construct(
        private ProgramService $programsService,
        private ValidatorService $validatorService
    ) {}

    #[Route(name: 'programs_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->programsService->getAllPrograms());
    }

    #[Route('/new', name: 'programs_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        $program = new Programs();
        $program->setName($data['name'] ?? '');
        $program->setDescription($data['description'] ?? '');
        $program->setDurationWeeks($data['duration_weeks'] ?? '');

        $errors = $this->validatorService->validateProgramData($program);
        if ($errors) {
            return new JsonResponse(['errors' => $errors], 400);
        }

        $this->programsService->createProgram($program);

        return new JsonResponse(['message' => 'Program created'], 201);
    }

    #[Route('/{id}', name: 'programs_show', methods: ['GET'])]
    public function show(Programs $program): JsonResponse
    {
        return new JsonResponse([
            'id' => $program->getId(),
            'name' => $program->getName(),
            'description' => $program->getDescription(),
            'duration_weeks' => $program->getDurationWeeks()
        ]);
    }

    #[Route('/{id}/edit', name: 'programs_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, Programs $program): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        if (isset($data['name'])) {
            $program->setName($data['name']);
        }

        if (isset($data['description'])) {
            $program->setDescription($data['description']);
        }

        if (isset($data['duration_weeks'])) {
            $program->setDurationWeeks($data['duration_weeks']);
        }

        $errors = $this->validatorService->validateProgramData($program, false);
        if ($errors) {
            return new JsonResponse(['errors' => $errors], 400);
        }

        $this->programsService->updateProgram($program);

        return new JsonResponse(['message' => 'Program updated']);
    }

    #[Route('/{id}', name: 'programs_delete', methods: ['DELETE'])]
    public function delete(Programs $program): JsonResponse
    {
        $this->programsService->deleteProgram($program);
        return new JsonResponse(['message' => 'Program deleted']);
    }
}
