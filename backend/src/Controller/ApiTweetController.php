<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\LikeComment;
use App\Entity\Tweet;
use App\Entity\User;
use App\Repository\LikeCommentRepository;
use App\Repository\LikeRepository;
use App\Repository\RetweetCommentRepository;
use App\Repository\RetweetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_tweet')]
class ApiTweetController extends AbstractController
{
    private LikeCommentRepository $lcr;
    private RetweetCommentRepository $rcr;
    private $logger;


    public function __construct(LikeCommentRepository $lcr, RetweetCommentRepository $rcr, LoggerInterface $logger = null)
    {
        $this->lcr = $lcr;
        $this->rcr = $rcr;
        $this->logger = $logger;
    }

    // Mostrar todos los tweets del usuario a los que sigue el usuario en sesion
    // Se debe devolver un campo likeed que indique si ese tweet ya ha sido likeado o no por el usuario en sesion
    // Este campo tendra el identificador del usuario
    #[Route('/following/tweets', name: 'app_api_following_tweet', methods: ['GET'])]
    public function getFollowingTweets(LoggerInterface $logger, Security $security, LikeRepository $lr, RetweetRepository $rr): JsonResponse
    {
        // Obtener el usuario autenticado
        $user = $security->getUser();

        // Verificar si el usuario está autenticado
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // log messages can also contain placeholders, which are variable names
        // wrapped in braces whose values are passed as the second argument
        $this->logger->info('User {userId} is logged in', [
            'userId' => $user->getId(),
        ]);

        // Sacar los usuarios a los que sigue
        $followingUsers = $user->getFollowers();
        $followingTweets = [];
        foreach ($followingUsers as $fUser) {
            $tweets = $fUser->getFollowing()->getTweets();
            foreach ($tweets as $tweet) {
                $followingTweets[] = $this->transformTweet($tweet, $user->getId(), $lr, $rr);
            }
        }

        // Devolver una respuesta con los tweets del usuario
        return new JsonResponse(['userSession' => $user->getUsername(), 'data' => $followingTweets]);
    }

    // Devuelve todos los tweets del usuario en sesion
    #[Route('/all/tweets', name: 'app_all_tweets', methods: ['GET'])]
    public function getOwnTweets(UserRepository $ur, LikeRepository $lr, RetweetRepository $rr): Response
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
            $json_tweets[] = $this->transformTweet($tweet, $user->getId(), $lr, $rr);
        }

        return new JsonResponse(['success' => true, 'data' => $json_tweets]);
    }


    // Transforma la informacion de un tweet en json
    public function transformTweet(Tweet $tweet, int $userId, LikeRepository $lr, RetweetRepository $rr): array
    {
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

            $comments[] = $this->transformComment($comment, $userId);
        }

        // Hay que comprobar si el usuario en sesion ha dado like al tweet
        $isLiked = $lr->isLiked($userId, $tweet->getId());

        // Comprobar si el tweet ya fue retweeteado
        $isRetweeted = $rr->isRetweeted($userId, $tweet->getId());

        return [
            'id' => $tweet->getId(),
            'content' => $tweet->getContent(),
            'author' => $tweet->getUser()->getUsername(),
            'createdAt' => $tweet->getPublishDate()->format('Y-m-d H:i:s'),
            'retweets' => $retweets,
            'comments' => $comments,
            'liked' => $isLiked,
            'retweeted' => $isRetweeted,
            'retweetsCount' => count($retweets),
            'likesCount' => count($tweet->getLikesCount()),
            'commentsCount' => count($comments),
        ];
    }

    // Transformar comentarios a json
    public function transformComment(Comment $comment, int $userId): array
    {
        // Hay que comprobar si el usuario en sesion ha dado like al tweet
        $isLiked = $this->lcr->isLiked($userId, $comment->getId());

        // Comprobar si el comment ya fue retweeteado
        $isRetweeted = $this->rcr->isRetweeted($userId, $comment->getId());

        return [
            'id' => $comment->getId(),
            'author' => $comment->getAuthor()->getUsername(),
            'content' => $comment->getContent(),
            'parentComment' => $comment->getParentComment(),
            'liked' => $isLiked,
            'retweeted' => $isRetweeted,
            'likesCount' => count($comment->getLikeComments()) ? count($comment->getLikeComments()) : 0,
            'commentsCount' => 0, // TODO: sacar los comentarios que tienen como parentComment este comentario (CommentRepository)
            'retweetsCount' => count($comment->getRetweetComments()) ? count($comment->getRetweetComments()) : 0,
            'createdAt' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    // Almacenar el post (tweet) del usuario en la bbdd
    #[Route('/post/tweet', name: 'app_post_tweet', methods: ['POST'])]
    public function postTweet(UserRepository $ur, Request $request, EntityManagerInterface $emi, LikeRepository $lr, RetweetRepository $rr): JsonResponse
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

        $response = $this->transformTweet($tweet, $tweet->getUser()->getId(), $lr, $rr);

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
