<?php

namespace App\Controller;


use App\Entity\Job;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use function PHPUnit\Framework\returnArgument;

class JobOffersController extends AbstractController
{
    #[Route('/job/offers', name: 'job_offers')]
    public function index(ManagerRegistry $doctrine ,SessionInterface $session,UserRepository $userRepository): Response
    {
    if(!$session->has('user_id')){

        $this->addFlash('info','please login first');
       return  $this->redirecttoRoute('login');
    }
       else{
           $userId=$session->get('user_id');
           $result = $userRepository->find($userId);

           if(!($result->getUserType() =='recruiter' || $result->getUserType() =='admin')){

               $this->addFlash('error','access denied');
               return $this->redirectToRoute('home');
           }
           else{

               $repo = $doctrine->getRepository(Job::class,);
            $jobs = $repo->findBy(['recruiter'=>$userId] );

        }
    }
        return $this->render('job_offers/index.html.twig', [
            'jobs' => $jobs,
        ]);

    }

}

