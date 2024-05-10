<?php

namespace App\Controller;

use App\Form\ApplicationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Application;
use App\Entity\User;
use App\Entity\Job;

class ApplicationFormController extends AbstractController
{
    #[Route('/application/form/{recruiter}/{job}', name: 'application_form')]
    public function index($recruiter,$job,ManagerRegistry $doctrine): Response
    {
        
        $Application=new Application();
        $repo = $doctrine->getRepository(Job::class,);
        $job= $repo->findOneBy(['id'=>$job]);
        $repo = $doctrine->getRepository(user::class,);
        $Recruiter = $repo->findOneBy(['id'=>$recruiter]);
        $Application->setJob($job);
        $Application->setJobseeker($Recruiter);
        $Appform=$this->createForm(ApplicationType::class,$Application);
        if ($Appform->isSubmitted() && $Appform->isValid()){
            $Application->setMotivation($Appform->get('motivation')->getData());
            $file = $Appform->get('cv_path')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
    
            try {
                $file->move('%kernel.project_dir%/public/uploads/cv_applications', $newFilename);
            } catch (FileException $e) {
                // Handle exception if something happens during file upload}
            }
                $Application->setCvPath($newFilename);
            
                    $entityManager->persist($Application);
                    $entityManager->flush();
            
        }

                        
                    
    }    
                
                return $this->render('application_form/index.html.twig', [
                    'Appform'=>$Appform->createView(),
                    'controller_name' => 'ApplicationFormController',
                ]);
            
}}