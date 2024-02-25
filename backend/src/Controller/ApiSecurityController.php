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

class ApiSecurityController extends AbstractController
{
    // Login si existe el usuario en la bbdd
    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function login(#[CurrentUser] User $user = null): JsonResponse
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
    public function logout(Security $security, #[CurrentUser] User $user = null): JsonResponse
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
}
