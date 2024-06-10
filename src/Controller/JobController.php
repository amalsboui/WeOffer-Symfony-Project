<?php
// src/Controller/JobController.php
namespace App\Controller;

use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    #[Route("/job_details/{id}", name:"job_details")]
    public function show(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        
        $job = $entityManager->getRepository(Job::class)->find($id);

        if (!$job) {
            throw $this->createNotFoundException('Job not found');
        }
        $timeDifference = $this->calculateTime($job->getCreatedAt());

 
        return $this->render('job_details/show.html.twig', [
            'job' => $job,
            'timeDifference' => $timeDifference,
        ]);
    }

    private function calculateTime(\DateTimeInterface $created): string
    {
        $currentTime = new \DateTime();
        $interval = $created->diff($currentTime);

        if ($interval->m == 1) {
            return '1 month ago';
        } elseif ($interval->m > 1) {
            return $interval->m . ' months ago';
        } elseif ($interval->d == 1) {
            return '1 day ago';
        } elseif ($interval->d > 1) {
            return $interval->d . ' days ago';
        } elseif ($interval->h == 1) {
            return '1 hour ago';
        } else {
            return $interval->h . ' hours ago';
        }
    }
}
