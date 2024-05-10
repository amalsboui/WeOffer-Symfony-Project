<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JObController extends AbstractController
{
    #[Route('/j/ob', name: 'app_j_ob')]
    public function index(): Response
    {
        return $this->render('j_ob/index.html.twig', [
            'controller_name' => 'JObController',
        ]);
    }
}
