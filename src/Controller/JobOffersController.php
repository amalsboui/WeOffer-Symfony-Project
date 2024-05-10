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
       return  $this->redirecttoRoute('login');
    }
       else{
           $id=$session->get('user_id');
            $id=2;
           $repo = $doctrine->getRepository(User::class,);
           $result = $repo->findOneBy(['id'=>$id]);

           if(!($result->getUserType() =='recruiter' || $result->getUserType() =='admin')){

               $this->addFlash('error','access denied');
               return $this->redirectToRoute('home');
           }
           else{

        $repo = $doctrine->getRepository(Job::class,);
        $jobs = $repo->findBy(['recruiter'=>$id] );

        }
    }
        return $this->render('job_offers/index.html.twig', [
            'jobs' => $jobs,
        ]);

    }

}

