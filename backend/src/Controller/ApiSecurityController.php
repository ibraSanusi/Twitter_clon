<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ApiSecurityController extends AbstractController
{
    // Login si existe el usuario en la bbdd
    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function loginApi(#[CurrentUser] User $user = null): JsonResponse
    {
        return new JsonResponse([
            'data' => [
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
            ]
        ]);
    }

    // Logout
    #[Route('/api/logout', name: 'app_api_logout')]
    public function logoutApi(Security $security, #[CurrentUser] User $user = null): JsonResponse
    {
        if ($user) {
            $security->logout();
            return new Response('Se cerro la sesion correctamente.', Response::HTTP_ACCEPTED);
        }
        return new JsonResponse($user, Response::HTTP_ACCEPTED);
    }

    #[Route('/api/logout/res', name: 'app_api_res')]
    public function logoutRes(): JsonResponse
    {
        return new JsonResponse('Cerrada la sesion', Response::HTTP_ACCEPTED);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
        // Este método nunca se ejecutará ya que Symfony manejará automáticamente el cierre de sesión
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
