<?php

namespace App\Controller;

use App\Controller\Newsletter\EmailNotification;
use App\Entity\User;
use App\Form\SignUpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/inscription', name: 'app_signUp')]
    public function signUp(Request $req, EntityManagerInterface $em, EmailNotification $emailNotification, Security $security): Response
    {
        $user = new User();
        $form = $this->createForm(SignUpType::class, $user);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($user);
                $em->flush();

                $emailNotification->sendSignUpConfirmationEmail($user);

                $security->login($user);

                return $this->redirectToRoute('app_signUp_thanks', ['email' => $user->getEmail()]);
            } catch (\Exception $e) {
                $this->addFlash('error', "L'email est déjà utilisé");
                return $this->redirectToRoute('app_signUp');
            }
        }

        return $this->render('security/signUp.html.twig', [
            'signUpForm' => $form,
        ]);
    }
    #[Route('/inscription/thanks/{email}', name: 'app_signUp_thanks')]
    public function thanks(string $email): Response
    {
        return $this->render('security/signUpThanks.html.twig', ['email' => $email]);
    }
}
