<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JobOffersController extends AbstractController
{
    #[Route('/job/offers', name: 'app_job_offers')]
    public function index(): Response
    {
        return $this->render('job_offers/index.html.twig', [
            'controller_name' => 'JobOffersController',
        ]);
    }
}
