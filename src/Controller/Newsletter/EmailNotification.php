<?php

namespace App\Controller\Newsletter;

use App\Entity\Ask;
use App\Entity\NewsletterEmail;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotification
{
    public function __construct(private MailerInterface $mailer, private string $adminEmail, private string $propositionEmail)
    {
    }

    public function sendNewsletterConfirmationEmail(NewsletterEmail $newEmail): void
    {
        $email = (new Email())
            ->from($this->adminEmail)
            ->to($newEmail->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Manga Collec Newsletter')
            ->text('Votre email ' . $newEmail->getEmail() . ' a bien été enregistré. Merci pour votre inscription à la newsletter');
        //->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }

    public function sendSignInConfirmationEmail(User $user): void
    {
        $email = (new Email())
            ->from($this->adminEmail)
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Manga Collec Inscription')
            ->text('Bienvenue chez Manga Collec ' . $user->getEmail() . ' ! Merci de vous être inscrit et profitez bien de nos services.');
        //->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }

    public function sendAskEmail(Ask $ask): void
    {
        $email = (new Email())
            ->from($this->propositionEmail)
            ->to($this->adminEmail)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Manga Collec Proposition #' . $ask->getId())
            ->text("Demande #" . $ask->getId() . ", Manga : " . $ask->getTitle() . ", auteur : " . $ask->getAuthor() . ", maison d'édition : " . $ask->getEditor());
        //->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}