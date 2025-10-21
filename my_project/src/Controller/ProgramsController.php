<?php

namespace App\Controller;

use App\Entity\Programs;
use App\Form\ProgramsType;
use App\Repository\ProgramsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programs')]
final class ProgramsController extends AbstractController
{
    #[Route(name: 'app_programs_index', methods: ['GET'])]
    public function index(ProgramsRepository $programsRepository): Response
    {
        return $this->render('programs/index.html.twig', [
            'programs' => $programsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_programs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $program = new Programs();
        $form = $this->createForm(ProgramsType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('app_programs_index', [], Response::HTTP_SEE_OTHER);
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
    public function edit(Request $request, Programs $program, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProgramsType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_programs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programs/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programs_delete', methods: ['POST'])]
    public function delete(Request $request, Programs $program, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_programs_index', [], Response::HTTP_SEE_OTHER);
    }
}
