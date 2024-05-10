<?php

namespace App\Controller;


use App\Entity\Job;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use function PHPUnit\Framework\returnArgument;

class JobOffersController extends AbstractController
{
    #[Route('/job/offers', name: 'app_job_offers')]
    public function index(ManagerRegistry $doctrine ,SessionInterface $session): Response
    {
    if(!$session->has('user_id')){
        $this->addFlash('info','please login first');
        $this->redirecttoRoute('login');
    }
       else{
           $repo = $doctrine->getRepository(User::class,);
           $result = $repo->find($session->get('user_id'));
           if(!($result->position =='recruiter ' || $result->position =='admin')){
               $this->addFlash('error','access denied');
                $this->redirectToRoute('home');
           }
           else{
        $repo = $doctrine->getRepository(Job::class,);
        $result = $repo->find($session->get('user_id'));

        }
    }
        return $this->render('job_offers/index.html.twig', [
            'controller_name' => 'JobOffersController',
        ]);

    }
}
