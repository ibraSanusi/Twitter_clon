<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
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

    // #[Route('/api/login', name: 'api_login')]
    // public function index(
    //     Request $request,
    //     UserPasswordHasherInterface $passwordHasher,
    //     UserRepository $userRepository,
    //     Session $session
    // ): Response {
    //     // Decodificar el JSON enviado en el cuerpo de la solicitud
    //     $data = json_decode($request->getContent(), true);

    //     // Verificar si se enviaron las credenciales
    //     if (!isset($data['username']) || !isset($data['password'])) {
    //         return new JsonResponse(['error' => 'Credenciales incompletas'], Response::HTTP_BAD_REQUEST);
    //     }

    //     // Obtener el nombre de usuario y la contraseña del cuerpo de la solicitud
    //     $username = $data['username'];
    //     $password = $data['password'];

    //     // Buscar al usuario en la base de datos por su nombre de usuario
    //     $user = $userRepository->findOneBy(['username' => $username]);

    //     // Verificar si se encontró un usuario
    //     if (!$user) {
    //         return new JsonResponse(['error' => 'Usuario no encontrado'], Response::HTTP_UNAUTHORIZED);
    //     }

    //     // Verificar si la contraseña es válida
    //     if (!$passwordHasher->isPasswordValid($user, $password)) {
    //         return new JsonResponse(['error' => 'Credenciales inválidas'], Response::HTTP_UNAUTHORIZED);
    //     }

    //     $session->set('token', 'validated');
    //     return $this->json([
    //         'data' => [
    //             'username' => $username,
    //             'password' => $password,
    //             'token' => 'validated',
    //         ],
    //     ]);
    // }

    // #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    // public function login(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository, Session $session): JsonResponse
    // {
    //     // Decodificar el JSON enviado en el cuerpo de la solicitud
    //     $data = json_decode($request->getContent(), true);

    //     // Verificar si se enviaron las credenciales
    //     if (!isset($data['username']) || !isset($data['password'])) {
    //         return new JsonResponse(['error' => 'Credenciales incompletas'], Response::HTTP_BAD_REQUEST);
    //     }

    //     // Obtener el nombre de usuario y la contraseña del cuerpo de la solicitud
    //     $username = $data['username'];
    //     $password = $data['password'];

    //     // Buscar al usuario en la base de datos por su nombre de usuario
    //     $user = $userRepository->findOneBy(['username' => $username]);

    //     // Verificar si se encontró un usuario
    //     if (!$user) {
    //         return new JsonResponse(['error' => 'Usuario no encontrado'], Response::HTTP_UNAUTHORIZED);
    //     }

    //     // Verificar si la contraseña es válida
    //     if (!$passwordHasher->isPasswordValid($user, $password)) {
    //         return new JsonResponse(['error' => 'Credenciales inválidas'], Response::HTTP_UNAUTHORIZED);
    //     }

    //     // Si las credenciales son válidas, generar un token de sesión
    //     $token = 'validated';

    //     // Establecer un token para la sesion
    //     $session->set('token', $token);

    //     // Retornar una respuesta JSON con los datos del usuario y el token
    //     return new JsonResponse([
    //         'data' => [
    //             'username' => $username,
    //             'password' => $password,
    //             'remember' => $data['remember'],
    //             'token' => $token,
    //         ],
    //         'token' => $token,
    //     ]);
    // }
}
