<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddJobController extends AbstractController
{
    #[Route('/add/job', name: 'app_add_job')]
    public function index(): Response
    {
        return $this->render('add_job/index.html.twig', [
            'controller_name' => 'AddJobController',
        ]);
    }
}
