<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\AddajobType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class AddJobController extends AbstractController
{
    #[Route('/add/job', name: 'app_add_job')]
    public function index(Request $request,EntityManagerInterface $entityManager,SessionInterface $session,Security $security): Response
    {   $time=new \DateTimeImmutable();
        $job=new Job();
        $sessionId=$session->getId();
        $form=$this->createForm(AddajobType::class,$job);
        $form->handleRequest($request);
        //if ($form->isSubmitted() && $form->isValid()) {
           // $job->setRecruiter($user);
            //$job->setCreatedAt($time);
          //$entityManager->persist($job);
          //$entityManager->flush();
      //  }
        return $this->render('add_job/index.html.twig',['job'=>$job,'form'=>$form->createView()]);

    }
}
