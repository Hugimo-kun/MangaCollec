<?php

namespace App\Controller;

use App\Controller\Newsletter\EmailNotification;
use App\Entity\Ask;
use App\Form\AskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AskController extends AbstractController
{
    #[Route('/ask', name: 'app_ask')]
    public function ask(Request $request, EntityManagerInterface $em, EmailNotification $emailNotification): Response
    {
        $ask = new Ask();
        $form = $this->createForm(AskType::class, $ask);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ask);
            $em->flush();

            $emailNotification->sendAskEmail($ask);

            return $this->redirectToRoute('ask_thanks');
        }

        return $this->render('ask/index.html.twig', [
            'askForm' => $form,
        ]);
    }

    #[Route('/ask/thanks', name: 'ask_thanks')]
    public function thanks(): Response
    {
        return $this->render('ask/thanks.html.twig');
    }
}

