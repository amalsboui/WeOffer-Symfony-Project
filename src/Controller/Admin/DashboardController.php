<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Entity\Job;
use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    private UserRepository $userRepository;
    private $ApplicationRepository;
    private $JobRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $counts = $this->userRepository->countUsersByType();
        // Extract counts from the result
        $totalUsers = $counts[0]['totalUsers'];
        $totalJobSeekers = $counts[0]['totalJobSeekers'];
        $totalRecruiters = $counts[0]['totalRecruiters'];


/*
        $jobOffersCount = $this->JobRepository->countJobOffers();
        $totalJobOffers = $jobOffersCount[0]['totalJobOffers'];

        $ApplicationsCount = $this->ApplicationRepository->countApplications();
        $totalApplications = $jobOffersCount[0]['totalApplications'];
*/
        return $this->render('admin/home.html.twig', [
            'totalUsers' => $totalUsers,
            'totalJobSeekers' => $totalJobSeekers,
            'totalRecruiters' => $totalRecruiters,
            /*'totalJobOffers' => $totalJobOffers,
            'totalApplications' => $totalApplications,*/


        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Weoffer Admin Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'home'),
            MenuItem::linkToDashboard('Home', 'fa fa-home'),
            MenuItem::linkToCrud('Users', 'fas fa-users', User::class),
            MenuItem::linkToCrud('Jobs', 'fas fa-briefcase', Job::class),
            MenuItem::linkToCrud('Applications', 'fas fa-file', Application::class),

        ];
    }
}