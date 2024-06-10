<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Entity\Job;
use App\Entity\User;
use App\Repository\ApplicationRepository;
use App\Repository\JobRepository;
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

    public function __construct(UserRepository $userRepository,JobRepository $JobRepository,ApplicationRepository $ApplicationRepository)
    {
        $this->userRepository = $userRepository;
        $this->JobRepository = $JobRepository;
        $this->ApplicationRepository = $ApplicationRepository;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $totalUsers = $this->userRepository->countUsers();
        $totalRecruiters = $this->userRepository->countRecruiters();
        $totalJobSeekers = $this->userRepository->countJobSeekers();
        $totalJobOffers = $this->JobRepository->countJobOffers();
        $totalApplications = $this->ApplicationRepository->countApplications();


        return $this->render('admin/home.html.twig', [
            'totalUsers' => $totalUsers,
            'totalJobSeekers' => $totalJobSeekers,
            'totalRecruiters' => $totalRecruiters,
            'totalJobOffers' => $totalJobOffers,
           'totalApplications' => $totalApplications,


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