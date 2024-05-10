<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\UpdateFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\Persistence\ManagerRegistry;



class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'profile')]
    public function index($id,SessionInterface $session,ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(user::class,);
        $user = $repo->findBy(['id'=>$id]);
        return $this->render('profile/index.html.twig', [
            'user'=>$user,
        ]);
    }
    #[Route('/profile/update/{id}', name: 'profileupdate')]
    public function update($id,Request $request,SessionInterface $session,SluggerInterface $slugger  ,ManagerRegistry $doctrine,EntityManagerInterface $entityManager): Response
    {  
        
        $repo = $doctrine->getRepository(user::class,);
        $user = $repo->findBy(['id'=>$id]);
        dd($user);
        $Userform=$this->createForm(UpdateFormType::class,$user);
        $Userform->handleRequest($request);
        if ($Userform->isSubmitted() && $Userform->isValid()){
            if ($user){
            $user->setPersonalnfo($Userform->get('personal_info')->getData());
            $user->setJob($Userform->get('job')->getData());
            $user->setCity($Userform->get('city')->getData());
            $photo = $Userform->get('image_url')->getData();

 
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();




    
    try {
        $photo->move('%kernel.project_dir%/public/uploads/users', $newFilename);
    } catch (FileException $e) {
        // Handle exception if something happens during file upload
    }


                
                $user->setImageUrl($newFilename);
            }}
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('profile/update.html.twig', [
            'Userform'=>$Userform->createView(),
            'controller_name' => 'ProfileController',
        ]);
    }
}
