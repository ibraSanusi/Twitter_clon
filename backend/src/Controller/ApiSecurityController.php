<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
                'roles' => $user->getRoles(),
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
        // Verificar si se ha enviado el formulario de inicio de sesión
        if ($this->getUser()) {
            $user = $this->getUser();

            if (!$user instanceof User) {
                return new Response('No es un usuario valido.');
            }

            $roles = $user->getRoles();

            // Redirigir al dashboard correspondiente según el rol del usuario
            if ($roles[0] === 'ROLE_ADMIN') {
                return $this->redirectToRoute('admin');
            } else {
                return $this->redirectToRoute('prueba');
            }
        }

        // Obtener el error de inicio de sesión, si lo hay
        $error = $authenticationUtils->getLastAuthenticationError();

        // Último nombre de usuario ingresado por el usuario
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

    #[Route('/prueba', name: 'prueba')]
    public function example(): Response
    {
        return new Response('Eureca.');
    }

    // Comprobar si esta la sesion iniciada
    #[Route('/anonymous/checkSession', name: 'check_session')]
    public function checkSession(): JsonResponse
    {
        $session = false;

        if ($this->getUser()) $session = true;

        return new JsonResponse($session);
    }

    // Mostrar todos los tweets
    #[Route('/showalltweets', name: 'show_all_tweets')]
    public function showAlltweets(TweetRepository $tr): JsonResponse
    {
        $tweets = $tr->findAll();

        $tweetsResponse = [];

        foreach ($tweets as $tweet) {
            // Sacar los retweets del tweet
            $retweets = [];
            foreach ($tweet->getRetweets() as $retweet) {
                $retweets[] = [
                    'id' => $retweet->getId(),
                    'tweet' => $retweet->getTweet()->getId(),
                    'createdAt' => $retweet->getRetweetDate()->format('Y-m-d H:i:s'),
                    'userId' => $retweet->getUser()->getId(),
                ];
            }

            // Sacar los comentarios del tweet
            $comments = [];
            foreach ($tweet->getComments() as $comment) {
                if (!$comment instanceof Comment) return null;

                $comments[] = [
                    'id' => $comment->getId(),
                    'author' => $comment->getAuthor()->getUsername(),
                    'content' => $comment->getContent(),
                    'parentComment' => $comment->getParentComment(),
                    'liked' => false,
                    'retweeted' => false,
                    'likesCount' => count($comment->getLikeComments()) ? count($comment->getLikeComments()) : 0,
                    'commentsCount' => 0, // TODO: sacar los comentarios que tienen como parentComment este comentario (CommentRepository)
                    'retweetsCount' => count($comment->getRetweetComments()) ? count($comment->getRetweetComments()) : 0,
                    'createdAt' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                ];
            }

            $tweetsResponse[] = [
                'id' => $tweet->getId(),
                'content' => $tweet->getContent(),
                'author' => $tweet->getUser()->getUsername(),
                'createdAt' => $tweet->getPublishDate()->format('Y-m-d H:i:s'),
                'retweets' => $retweets,
                'comments' => $comments,
                'liked' => false,
                'retweeted' => false,
                'retweetsCount' => count($retweets),
                'likesCount' => count($tweet->getLikesCount()),
                'commentsCount' => 0,
            ];
        }

        return new JsonResponse([
            'userSession' => 'none',
            'data' => $tweetsResponse,
        ]);
    }
}
