<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route(
        path: '/inscription',
        name: 'inscription'
    )]
    public function subscribe(): Response
    {
        return $this->render('security/connexion.html.twig', []);
    }


    #[Route(
        path: '/connexion',
        name: 'connexion'
    )]
    public function connect(): Response
    {
        return $this->render('security/connexion.html.twig', []);
    }
}
