<?php

namespace App\Controller;

use App\Entity\ClientPrograms;
use App\Form\ClientProgramsType;
use App\Repository\ClientProgramsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/client/programs')]
final class ClientProgramsController extends AbstractController
{
    #[Route(name: 'app_client_programs_index', methods: ['GET'])]
    public function index(ClientProgramsRepository $clientProgramsRepository): Response
    {
        return $this->render('client_programs/index.html.twig', [
            'client_programs' => $clientProgramsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_programs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $clientProgram = new ClientPrograms();
        $form = $this->createForm(ClientProgramsType::class, $clientProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($clientProgram);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_programs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client_programs/new.html.twig', [
            'client_program' => $clientProgram,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_programs_show', methods: ['GET'])]
    public function show(ClientPrograms $clientProgram): Response
    {
        return $this->render('client_programs/show.html.twig', [
            'client_program' => $clientProgram,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_programs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClientPrograms $clientProgram, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientProgramsType::class, $clientProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_programs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client_programs/edit.html.twig', [
            'client_program' => $clientProgram,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_programs_delete', methods: ['POST'])]
    public function delete(Request $request, ClientPrograms $clientProgram, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clientProgram->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($clientProgram);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client_programs_index', [], Response::HTTP_SEE_OTHER);
    }
}
