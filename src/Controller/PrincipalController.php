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

}
