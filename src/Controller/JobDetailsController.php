<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JobDetailsController extends AbstractController
{
    #[Route('/job/details', name: 'job_details')]
    public function index(): Response
    {
        return $this->render('job_details/index.html.twig', [
            'controller_name' => 'JobDetailsController',
        ]);
    }
}
