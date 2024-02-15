<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// class SecurityController extends AbstractController
// {
//     #[Route('/login', name: 'app_login')]
//     public function login(AuthenticationUtils $authenticationUtils): Response
//     {
//         // get the login error if there is one
//         $error = $authenticationUtils->getLastAuthenticationError();

//         // last username entered by the user
//         $lastUsername = $authenticationUtils->getLastUsername();

//         return $this->render('login/index.html.twig', [
//             'controller_name' => 'LoginController',
//             'last_username' => $lastUsername,
//             'error' => $error,
//         ]);
//     }

//     // #[Route('/logout', name: 'app_logout')]
//     // public function logout(): Response
//     // {
//     //     // Este método nunca se ejecutará ya que Symfony manejará automáticamente el cierre de sesión
//     //     throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
//     // }
// }
