<?php

namespace App\Controller;

use App\Form\ApplicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Application;
use App\Entity\User;
use App\Entity\Job;
use Symfony\Component\String\Slugger\SluggerInterface;

class ApplicationFormController extends AbstractController
{
    #[Route('/application/form/{job}', name: 'application_form')]
    public function index($job,ManagerRegistry $doctrine,EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        
        $Application=new Application();
        $repo = $doctrine->getRepository(Job::class,);
        $job= $repo->findOneBy(['id'=>$job]);
        $Application->setJob($job);
        $Appform=$this->createForm(ApplicationType::class,$Application);
        if ($Appform->isSubmitted() && $Appform->isValid()){
            $Application->setMotivation($Appform->get('motivation')->getData());
            $file = $Appform->get('cv_path')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
                $file->move('%kernel.project_dir%/public/uploads/cv_applications', $newFilename);
                $Application->setCvPath($newFilename);
                $entityManager->persist($Application);
                $entityManager->flush();
        }
    }
                return $this->render('application_form/index.html.twig', [
                    'ApplicationType'=>$Appform->createView(),
                    'controller_name' => 'ApplicationFormController',
                    'job'=>$job
                ]);
}}