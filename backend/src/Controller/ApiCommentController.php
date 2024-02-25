<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tweet;
use App\Repository\CommentRepository;
use App\Repository\LikeCommentRepository;
use App\Repository\RetweetCommentRepository;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app_comment_api')]
class ApiCommentController extends AbstractController
{
    private LikeCommentRepository $lcr;
    private RetweetCommentRepository $rcr;

    public function __construct(LikeCommentRepository $lcr, RetweetCommentRepository $rcr)
    {
        $this->lcr = $lcr;
        $this->rcr = $rcr;
    }

    // Hacer un comentario a un tweet
    #[Route('/comment', name: 'app_comment')]
    public function comment(UserRepository $ur, Request $request, EntityManagerInterface $emi, TweetRepository $tr): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $ur->find($this->getUser());

        $currentDateTime = new \DateTime('now');

        $tweetId = $data['tweetId'];
        $content = $data['content'];

        $comment = new Comment();

        $tweet = $tr->find($tweetId);

        $comment->setContent($content);
        $comment->setTweet($tweet);
        $comment->setAuthor($user);
        $comment->setCreatedAt($currentDateTime);

        $emi->persist($comment);
        $emi->flush();

        $response = $this->transformComment($comment, $user->getId());

        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    // Hacer un comentario a un comentario
    #[Route('/comment/comment', name: 'app_comment_comment')]
    public function commentAComment(UserRepository $ur, Request $request, EntityManagerInterface $emi, CommentRepository $cr): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $ur->find($this->getUser());

        $currentDateTime = new \DateTime('now');

        $commentId = $data['commentId'];
        $content = $data['content'];

        $parentComment = $cr->find($commentId);

        if (!$parentComment instanceof Comment) return new JsonResponse('No existe ese comentario.', Response::HTTP_INTERNAL_SERVER_ERROR);

        $comment = new Comment();

        $tweet = $parentComment->getTweet();

        if (!$tweet instanceof Tweet) return new JsonResponse('Ese tweet no existe.', Response::HTTP_INTERNAL_SERVER_ERROR);

        $comment->setContent($content);
        $comment->setTweet($tweet);
        $comment->setAuthor($user);
        $comment->setParentComment($parentComment->getId());
        $comment->setCreatedAt($currentDateTime);

        $emi->persist($comment);
        $emi->flush();

        return new JsonResponse('El usuario ' . $user->getUsername() . ' ha comentado el comentario: ' . $comment->getContent() . ' de ' . $tweet->getUser()->getUsername());
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
}
