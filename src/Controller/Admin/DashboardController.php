<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Entity\Job;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();
        /*$userRepository = $this->entityManager->getRepository(User::class);
        $counts = $userRepository->countUsersByType();
        $totalUsers = $counts[0]['totalUsers'];
        $totalJobSeekers = $counts[0]['totalJobSeekers'];
        $totalRecruiters = $counts[0]['totalRecruiters'];

        return $this->render('home_admin/index.html.twig',[
            'totalUsers' => $totalUsers,
            'totalJobSeekers' => $totalJobSeekers,
            'totalRecruiters' => $totalRecruiters,
        ]);*/

         return $this->render('admin/home.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Weoffer Admin Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Home', 'fa fa-home'),
            MenuItem::linkToCrud('Users', 'fas fa-users', User::class),
            MenuItem::linkToCrud('Jobs', 'fas fa-briefcase', Job::class),
            MenuItem::linkToCrud('Applications', 'fas fa-file', Application::class),

        ];
    }
}
