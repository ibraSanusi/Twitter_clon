<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiTweetController extends AbstractController
{
    // Mostrar todos los tweets del usuario en sesion
    #[Route('/api/tweets', name: 'app_api_tweet', methods: ['GET'])]
    public function getOwnTweets(UserRepository $userRepository, Security $security): JsonResponse
    {
        // Obtener el usuario autenticado
        $user = $security->getUser();

        // Verificar si el usuario está autenticado
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // Obtener el nombre de usuario y los tweets del usuario
        $username = $user->getUsername();
        $tweets = $user->getTweets();

        // Construir un array con los tweets del usuario
        $userTweets = [];
        foreach ($tweets as $tweet) {
            $userTweets[] = [
                'id' => $tweet->getId(),
                'content' => $tweet->getContent(),
                'publish_date' => $tweet->getPublishDate()->format('Y-m-d H:i:s'),
                'author' => $username
            ];
        }

        // Devolver una respuesta con los tweets del usuario
        return new JsonResponse(['success' => true, 'data' => $userTweets]);
    }

    // Mostrar todos los tweets del usuario a los que sigue el usuario en sesion
    #[Route('/api/following/tweets', name: 'app_api_following_tweet', methods: ['GET'])]
    public function getFollowingTweets(UserRepository $userRepository, Security $security): JsonResponse
    {
        // Obtener el usuario autenticado
        $user = $security->getUser();

        // Verificar si el usuario está autenticado
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // Obtener el nombre de usuario y los tweets del usuario
        $username = $user->getUsername();

        // Sacar los usuarios a los que sigue
        $followingUsers = $user->getFollowers();
        $followingTweets = [];
        foreach ($followingUsers as $fUser) {
            $tweets = $fUser->getFollowing()->getTweets();
            foreach ($tweets as $tweet) {
                $followingTweets[] = [
                    'id' => $tweet->getId(),
                    'content' => $tweet->getContent(),
                    'publish_date' => $tweet->getPublishDate()->format('Y-m-d H:i:s'),
                    'author' => $tweet->getUser()->getUsername()
                ];
            }
        }

        // Devolver una respuesta con los tweets del usuario
        return new JsonResponse(['success' => true, 'data' => $followingTweets]);
    }
}
