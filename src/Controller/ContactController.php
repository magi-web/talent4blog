<?php

namespace App\Controller;

use App\Form\ContactMessageType;
use App\Model\ContactMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactMessageType::class, new ContactMessage());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ContactMessage $contactMessage */
            $contactMessage = $form->getData();

            $email = (new Email())
                ->subject($contactMessage->getSubject())
                ->from($contactMessage->getFrom())
                ->text($contactMessage->getMessage())
                ->html($contactMessage->getMessage())
                ->to($this->getParameter('ADMIN_EMAIL'));

            $mailer->send($email);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
