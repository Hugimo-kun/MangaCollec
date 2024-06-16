<?php

namespace App\Controller;

use App\Controller\Newsletter\EmailNotification;
use App\Entity\NewsletterEmail;
use App\Form\NewsletterEmailType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter')]
    public function subscribe(Request $request, EntityManagerInterface $em, EmailNotification $emailNotification): Response
    {
        $newsletterEmail = new NewsletterEmail();
        $form = $this->createForm(NewsletterEmailType::class, $newsletterEmail);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newsletterEmail);
            $em->flush();

            $emailNotification->sendNewsletterConfirmationEmail($newsletterEmail);

            return $this->redirectToRoute('newsletter_thanks', ['email' => $newsletterEmail->getEmail()]);
        }

        return $this->render('newsletter/newsletterSubscription.html.twig', [
            'newsletterForm' => $form,
        ]);
    }

    #[Route('/newsletter/thanks/{email}', name: 'newsletter_thanks')]
    public function thanks(string $email): Response
    {
        return $this->render('newsletter/thanks.html.twig', ['email' => $email]);
    }
}
