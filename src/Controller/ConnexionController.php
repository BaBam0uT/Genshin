<?php

namespace App\Controller;

use App\Entity\Connexion;
use App\Form\ConnexionType;
use App\Repository\ConnexionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/connexion')]
class ConnexionController extends AbstractController
{
    #[Route('/', name: 'connexion_index', methods: ['GET'])]
    public function index(ConnexionRepository $connexionRepository): Response
    {
        return $this->render('connexion/index.html.twig', [
            'connexions' => $connexionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'connexion_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $connexion = new Connexion();
        $form = $this->createForm(ConnexionType::class, $connexion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($connexion);
            $entityManager->flush();

            return $this->redirectToRoute('connexion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('connexion/new.html.twig', [
            'connexion' => $connexion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'connexion_show', methods: ['GET'])]
    public function show(Connexion $connexion): Response
    {
        return $this->render('connexion/show.html.twig', [
            'connexion' => $connexion,
        ]);
    }

    #[Route('/{id}/edit', name: 'connexion_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Connexion $connexion): Response
    {
        $form = $this->createForm(ConnexionType::class, $connexion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('connexion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('connexion/edit.html.twig', [
            'connexion' => $connexion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'connexion_delete', methods: ['POST'])]
    public function delete(Request $request, Connexion $connexion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$connexion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($connexion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('connexion_index', [], Response::HTTP_SEE_OTHER);
    }
}
