<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(SessionInterface $session): Response
    {
        $user = $this->getUser();
        return $this->render('profile/index.html.twig', [
            'user'=>$user,
            'controller_name' => 'ProfileController',
        ]);
    }
    #[Route('/profile/update', name: 'profileupdate')]
    public function update(): Response
    {
        return $this->render('profile/update.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
