<?php

namespace App\Controller;

use App\Entity\Actualites;
use App\Form\ActualitesType;
use App\Repository\ActualitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/actualites')]
class ActualitesController extends AbstractController
{
    #[Route('/', name: 'actualites_index', methods: ['GET'])]
    public function index(ActualitesRepository $actualitesRepository): Response
    {
        return $this->render('actualites/index.html.twig', [
            'actualites' => $actualitesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'actualites_new', methods: ['GET','POST'])]
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $actualite = new Actualites();
        $form = $this->createForm(ActualitesType::class, $actualite);
        $form->handleRequest($request);

        $thumbnailFile = $form->get('thumbnail')->getData();

        if($thumbnailFile) {
            $uploadName = pathinfo($thumbnailFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($uploadName);
            $storedName = $safeFilename.'-'.uniqid().'.'.$thumbnailFile->guessExtension();

            try {
                $thumbnailFile->move(
                    $this->getParameter('thumbnail_directory'),
                    $storedName
                );
            } catch(FileException $e) {
                // handle exception ...
            }

            // update : store the filename instead of its contents
            $actualite->setImage($storedName);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actualite);
            $entityManager->flush();

            return $this->redirectToRoute('actualites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualites/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);

    }

    #[Route('/{id}', name: 'actualites_show', methods: ['GET'])]
    public function show(Actualites $actualite): Response
    {
        return $this->render('actualites/show.html.twig', [
            'actualite' => $actualite,
        ]);
    }

    #[Route('/{id}/edit', name: 'actualites_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Actualites $actualite): Response
    {
        $form = $this->createForm(ActualitesType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actualites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualites/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'actualites_delete', methods: ['POST'])]
    public function delete(Request $request, Actualites $actualite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actualites_index', [], Response::HTTP_SEE_OTHER);
    }
}
