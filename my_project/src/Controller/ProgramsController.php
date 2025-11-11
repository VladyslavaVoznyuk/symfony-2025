<?php

namespace App\Controller;

use App\Entity\Programs;
use App\Form\ProgramsType;
use App\Repository\ProgramsRepository;
use App\Service\ProgramService;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programs')]
final class ProgramsController extends AbstractController
{
    private const ITEMS_PER_PAGE = 15;

    private ProgramService $programsService;
    private ValidatorService $validatorService;
    private ProgramsRepository $programsRepository;

    public function __construct(
        ProgramService $programsService,
        ValidatorService $validatorService,
        ProgramsRepository $programsRepository
    ) {
        $this->programsService = $programsService;
        $this->validatorService = $validatorService;
        $this->programsRepository = $programsRepository;
    }

    #[Route(name: 'app_programs_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $requestData = $request->query->all();

        $itemsPerPage = (int)($requestData['itemsPerPage'] ?? self::ITEMS_PER_PAGE);
        $page = (int)($requestData['page'] ?? 1);

        unset($requestData['itemsPerPage'], $requestData['page']);
        $filters = $requestData;

        $programsData = $this->programsRepository->getAllProgramsByFilter(
            $filters,
            $itemsPerPage,
            $page
        );

        return $this->render('programs/index.html.twig', [
            'programs' => $programsData['programs'],
            'pagination' => [
                'currentPage' => $page,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $programsData['totalItems'],
                'totalPageCount' => $programsData['totalPageCount'],
            ],
            'currentFilters' => $filters,
        ]);
    }

    #[Route('/new', name: 'app_programs_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $program = new Programs();
        $form = $this->createForm(ProgramsType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->validatorService->validateProgramData($form->getData());
            if ($errors) {
                $this->addFlash('error', implode(', ', $errors));
            } else {
                $this->programsService->createProgram($program);
                $this->addFlash('success', 'Програму успішно створено!');
                return $this->redirectToRoute('app_programs_index');
            }
        }

        return $this->render('programs/new.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programs_show', methods: ['GET'])]
    public function show(Programs $program): Response
    {
        return $this->render('programs/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_programs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Programs $program): Response
    {
        $form = $this->createForm(ProgramsType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->validatorService->validateProgramData($form->getData(), false);
            if ($errors) {
                $this->addFlash('error', implode(', ', $errors));
            } else {
                $this->programsService->updateProgram($program);
                $this->addFlash('success', 'Дані програми оновлено!');
                return $this->redirectToRoute('app_programs_index');
            }
        }

        return $this->render('programs/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programs_delete', methods: ['POST'])]
    public function delete(Request $request, Programs $program): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->getPayload()->getString('_token'))) {
            $this->programsService->deleteProgram($program);
            $this->addFlash('success', 'Програму видалено.');
        }

        return $this->redirectToRoute('app_programs_index');
    }
}