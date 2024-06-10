<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\Userform;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\Persistence\ManagerRegistry;



class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(SessionInterface $session,UserRepository $userRepository): Response
    {
        $userId = $session->get('user_id');
        $user = $userRepository->find($userId);
        return $this->render('profile/indexx.html.twig', [
            'user'=>$user
        ]);
    }
    #[Route('/profile/update', name: 'profileupdate')]
    public function update(UserRepository $userRepository,Request $request,SessionInterface $session,SluggerInterface $slugger  ,ManagerRegistry $doctrine,EntityManagerInterface $entityManager): Response
    {

        $userId = $session->get('user_id');
        $user = $userRepository->find($userId);
        $user_type=$user->getUserType();
        $Userform=$this->createForm(Userform::class,$user);
        $Userform->handleRequest($request);

        if ($Userform->isSubmitted() && $Userform->isValid()){
            if ($user){
            $user->setPersonalInfo($Userform->get('personal_info')->getData());
            $user->setJob($Userform->get('job')->getData());
            $user->setCity($Userform->get('city')->getData());
            $photo = $Userform->get('image_url')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
                $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/assets/uploads/users';
                $photo->move($uploadDirectory, $newFilename);
                $user->setImageUrl($newFilename);
            }}
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('profile');
        }
        return $this->render('profile/update.html.twig', [
            'Userform'=>$Userform->createView(),
            'user'=>$user,
            'user_type'=>$user_type,
            'personalinfo'=>$user->getPersonalinfo(),
            'controller_name' => 'Profileupdate',
        ]);
    }
}
