<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');

            try {
                $email = (new Email())
                    ->from($email)
                    ->to('oussamawaid@gmail.com') 
                    ->subject($subject)
                    ->text("From: $name\n\n$email\n\n$message");

                $mailer->send($email);

                $this->addFlash('success', 'Your message has been sent successfully.');
                return $this->redirectToRoute('contact');
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('error', 'Failed to send the message. Please try again later.');
            
            }
        }

        return $this->render('contact/index.html.twig');
    }
}
