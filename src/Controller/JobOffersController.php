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
           $result = $repo->findOneBy(['id'=>$session->get('user_id')]);
           dd($result);

           if(!($result->getPosition() =='recruiter ' || $result->getPosition() =='admin')){
               $this->addFlash('error','access denied');
                $this->redirectToRoute('home');
           }
           else{
        $repo = $doctrine->getRepository(Job::class,);
        $jobs = $repo->find($session->get('user_id'));


        }
    }
        return $this->render('job_offers/index.html.twig', [
            'jobs' => $jobs,
        ]);

    }
}
