<?php

namespace App\Controller;

use App\Entity\Trainers;
use App\Form\TrainersType;
use App\Repository\TrainersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/trainers')]
final class TrainersController extends AbstractController
{
    #[Route(name: 'app_trainers_index', methods: ['GET'])]
    public function index(TrainersRepository $trainersRepository): Response
    {
        return $this->render('trainers/index.html.twig', [
            'trainers' => $trainersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trainers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainer = new Trainers();
        $form = $this->createForm(TrainersType::class, $trainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainer);
            $entityManager->flush();

            return $this->redirectToRoute('app_trainers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trainers/new.html.twig', [
            'trainer' => $trainer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trainers_show', methods: ['GET'])]
    public function show(Trainers $trainer): Response
    {
        return $this->render('trainers/show.html.twig', [
            'trainer' => $trainer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trainers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trainers $trainer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrainersType::class, $trainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_trainers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trainers/edit.html.twig', [
            'trainer' => $trainer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trainers_delete', methods: ['POST'])]
    public function delete(Request $request, Trainers $trainer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($trainer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_trainers_index', [], Response::HTTP_SEE_OTHER);
    }
}
