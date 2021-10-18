<?php

namespace App\Controller;

use App\Entity\Actualites;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    #[Route('/', name: 'racine')]
    public function racine(): Response
    {
        return $this->render('base.html.twig', [

        ]);
    }

    #[Route('/Inscription', name: 'Inscription')]
    public function inscription(): Response
    {
        return $this->render('inscription/inscription.html.twig', [

        ]);
    }

    #[Route('/Actualités', name: 'Actualités')]
    public function actualites(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Actualites::class);

        $articles = $repo->findAll();

        return $this->render('actualités/actualites.html.twig', [
            'articles' => $articles
        ]);
    }
}
