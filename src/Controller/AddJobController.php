<?php

namespace App\Controller;
use App\Repository\UserRepository;
use App\Entity\User;
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
{   private RegistrationController $registrationController;
    private UserRepository $userRepository;
    #[Route('/add', name: 'app_add_job')]
    public function index(Request $request,EntityManagerInterface $entityManager,SessionInterface $session,UserRepository $userRepository,Security $security): Response
    { 
        $userId = $session->get('user_id');
        //$user = $userRepository->findOneByIdFromSession($userId);
         /** @var \App\Entity\User $user */
        $user=$this->getUser();
        //if(!$user) {
          //  return (new Response('<h1>user not found</h1>'));}
         $time=new \DateTimeImmutable();
        $job=new Job();
        $form=$this->createForm(AddajobType::class,$job);
        $form->handleRequest($request);
        
        
        //$user=$session->get('user');
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt($time);
            $job->setRecruiter($user);
            $job->setCreatedAt($time);
            $job->setCategory($form->get('category')->getData());
            $job->setPosition($form->get('position')->getData());
            $job->setDescription($form->get('description')->getData());
            $job->setEmploymentType($form->get('employment_type')->getData());
            $job->setEntreprise($form-> get('entreprise')->getData());
            $job->setLocation($form->get('location')->getData());
            $entityManager->persist($job);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('add_job/index.html.twig',['job'=>$job,'form'=>$form->createView()]);

    }
}
