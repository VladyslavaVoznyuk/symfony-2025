<?php

namespace App\Controller;

use App\Entity\ClientSession;
use App\Form\ClientSessionType;
use App\Repository\ClientSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/client/session')]
final class ClientSessionController extends AbstractController
{
    #[Route(name: 'app_client_session_index', methods: ['GET'])]
    public function index(ClientSessionRepository $clientSessionRepository): Response
    {
        return $this->render('client_session/index.html.twig', [
            'client_sessions' => $clientSessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $clientSession = new ClientSession();
        $form = $this->createForm(ClientSessionType::class, $clientSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($clientSession);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client_session/new.html.twig', [
            'client_session' => $clientSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_session_show', methods: ['GET'])]
    public function show(ClientSession $clientSession): Response
    {
        return $this->render('client_session/show.html.twig', [
            'client_session' => $clientSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClientSession $clientSession, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientSessionType::class, $clientSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client_session/edit.html.twig', [
            'client_session' => $clientSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_session_delete', methods: ['POST'])]
    public function delete(Request $request, ClientSession $clientSession, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clientSession->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($clientSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
