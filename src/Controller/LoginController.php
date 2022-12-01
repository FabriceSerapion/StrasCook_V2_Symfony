<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(
        AuthenticationUtils $authenticationUtils,
        RequestStack $requestStack,
        UserRepository $userRepository
    ): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        // GET USER FROM LOGIN
        $user = $userRepository->findByName($lastUsername);

        // GETTING SESSION
        $session = $requestStack->getSession();

        // FILL SESSION WITH 1 INFORMATION : USER ID
        if (!$session->has('idUser')) {
            $session->set('idUser', $user[0]->getId());

            return $this->render('login/index.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]);
        }
    }
}
