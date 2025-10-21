<?php

namespace App\Controller;

use App\Entity\Eqipment;
use App\Form\EqipmentType;
use App\Repository\EqipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/eqipment')]
final class EqipmentController extends AbstractController
{
    #[Route(name: 'app_eqipment_index', methods: ['GET'])]
    public function index(EqipmentRepository $eqipmentRepository): Response
    {
        return $this->render('eqipment/index.html.twig', [
            'eqipments' => $eqipmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_eqipment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eqipment = new Eqipment();
        $form = $this->createForm(EqipmentType::class, $eqipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eqipment);
            $entityManager->flush();

            return $this->redirectToRoute('app_eqipment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eqipment/new.html.twig', [
            'eqipment' => $eqipment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eqipment_show', methods: ['GET'])]
    public function show(Eqipment $eqipment): Response
    {
        return $this->render('eqipment/show.html.twig', [
            'eqipment' => $eqipment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eqipment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eqipment $eqipment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EqipmentType::class, $eqipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_eqipment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eqipment/edit.html.twig', [
            'eqipment' => $eqipment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eqipment_delete', methods: ['POST'])]
    public function delete(Request $request, Eqipment $eqipment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eqipment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($eqipment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_eqipment_index', [], Response::HTTP_SEE_OTHER);
    }
}
