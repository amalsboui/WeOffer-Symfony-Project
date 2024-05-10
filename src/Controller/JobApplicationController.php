<?php

namespace App\Controller;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class JobApplicationController extends AbstractController
{
    #[Route('/job/applications/{recruiter}/{job}', name: 'app_job_application')]
    public function index($recruiter,$job,ManagerRegistry $doctrine ,SessionInterface $session,EntityManagerInterface $entityManager): Response
    {
        if(!$session->has('user_id')){

            $this->addFlash('info','please login first');
            return  $this->redirecttoRoute('login');
        }
        else{
            $id=$session->get('user_id');
            $id=2;
            if($id!=$recruiter){

            $this->addFlash('error','access denied');
            return  $this->redirectToRoute('home');
            }
            else{
                $queryBuilder = $entityManager->createQueryBuilder();

                $queryBuilder
                    ->select('u.id','u.user_type', 'u.name', 'u.last_name', 'u.email', 'a.motivation', 'a.id')
                    ->from('App\Entity\User', 'u')
                    ->leftJoin('App\Entity\Application', 'a', 'WITH', 'a.jobseeker = u.id')
                    ->andWhere('a.job = :jobId')
                    ->setParameter('jobId', $job); // Assuming $jobId is the ID of the job you're querying for

                $query = $queryBuilder->getQuery();

                $application = $query->getResult();
            }


        }



        return $this->render('job_applications/index.html.twig', [
            'applications' => $application,
        ]);
    }
}
