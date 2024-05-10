<?php
// src/Controller/ContactController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
<<<<<<< HEAD
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
=======
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
>>>>>>> a355778db5405e38531890832f270fd216cb4022
    {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');
            $mail = (new Email());
                $mail->from($email);
                $mail->to('oussamawaid@gmail.com');
                $mail->subject($subject);
                $mail->text("From: $name\n\n$email\n\n$message");

            $mailer->send($mail);

            $this->addFlash('success', 'Your message has been sent successfully.');



        return $this->render('contact/index.html.twig');
    }
}
