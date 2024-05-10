<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\UpdateFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(SessionInterface $session): Response
    {
        $user=$this->getUser();
        return $this->render('profile/index.html.twig', [
            'user'=>$user,
        ]);
    }
    #[Route('/profile/update', name: 'profileupdate')]
    public function update(SessionInterface $session,EntityManagerInterface $entityManager): Response
    {   $user=$this->getUser();
        $Userform=$this->createForm(UpdateFormType::class,$this->getUser());
        if ($Userform->isSubmitted() && $Userform->isValid()){
            $user->setPersonalnfo($Userform->get('personal_info')->getData());
            $user->setJob($Userform->get('job')->getData());
            $user->setCity($Userform->get('city')->getData());
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('profile/update.html.twig', [
            'Userform'=>$Userform->createView(),
            'controller_name' => 'ProfileController',
        ]);
    }
}
