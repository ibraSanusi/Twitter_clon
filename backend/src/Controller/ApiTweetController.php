<?php

namespace App\Controller;

use App\Entity\Tweet;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_tweet')]
class ApiTweetController extends AbstractController
{
    // Mostrar todos los tweets del usuario a los que sigue el usuario en sesion
    #[Route('/following/tweets', name: 'app_api_following_tweet', methods: ['GET'])]
    public function getFollowingTweets(Security $security): JsonResponse
    {
        // Obtener el usuario autenticado
        $user = $security->getUser();

        // Verificar si el usuario está autenticado
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // Sacar los usuarios a los que sigue
        $followingUsers = $user->getFollowers();
        $followingTweets = [];
        foreach ($followingUsers as $fUser) {
            $tweets = $fUser->getFollowing()->getTweets();
            foreach ($tweets as $tweet) {
                $followingTweets[] = $this->transformTweet($tweet);
            }
        }

        // Devolver una respuesta con los tweets del usuario
        return new JsonResponse(['success' => true, 'data' => $followingTweets]);
    }

    // Devuelve todos los tweets del usuario en sesion
    #[Route('/all/tweets', name: 'app_all_tweets', methods: ['GET'])]
    public function getOwnTweets(UserRepository $ur): Response
    {
        // Verificar si el usuario está autenticado
        if (!$this->getUser() instanceof User) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        $user = $ur->find($this->getUser());
        $tweets = $user->getTweets();

        $json_tweets = [];
        // Convertir tweets en respuesta de tipo json
        foreach ($tweets as $tweet) {
            $json_tweets[] = $this->transformTweet($tweet);
        }

        return new JsonResponse(['success' => true, 'data' => $json_tweets]);
    }

    // Transforma la informacion de un tweet en json
    public function transformTweet($tweet): array
    {
        // Sacar los retweets del tweet
        $retweets = [];
        foreach ($tweet->getRetweets() as $retweet) {
            $retweets[] = [
                'id' => $retweet->getId(),
                'tweet' => $retweet->getTweet()->getId(),
                'retweetDate' => $retweet->getRetweetDate(),
                'userId' => $retweet->getUser()->getId(),
            ];
        }

        $json_tweets = [
            'id' => $tweet->getId(),
            'content' => $tweet->getContent(),
            'author' => $tweet->getUser()->getUsername(),
            'publishDate' => $tweet->getPublishDate()->format('Y-m-d H:i:s'),
            'retweets' => $retweets,
            'likesCount' => count($tweet->getLikesCount()),
        ];


        return $json_tweets;
    }

    // Almacenar el post (tweet) del usuario en la bbdd
    #[Route('/post/tweet', name: 'app_post_tweet', methods: ['POST'])]
    public function postTweet(UserRepository $ur, Request $request, EntityManagerInterface $emi): JsonResponse
    {
        $user = $ur->find($this->getUser());

        // Recupera los datos de la request
        // Crear el tweet y setear las propiedades necesarias
        $data = json_decode($request->getContent(), true);
        $tweetContent = $data['content'];

        $currentDateTime = new \DateTime('now');

        $tweet = new Tweet();
        $tweet->setUser($user);
        $tweet->setContent($tweetContent);
        $tweet->setPublishDate($currentDateTime);

        $emi->persist($tweet);
        $emi->flush();

        return new JsonResponse('Tweet subido correctamente', Response::HTTP_CREATED);
    }
}
