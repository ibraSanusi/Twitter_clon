<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app_comment_api')]
class ApiCommentController extends AbstractController
{
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

        return new JsonResponse('El usuario ' . $user->getUsername() . ' ha comentado el tweet: ' . $tweet->getContent() . ' de ' . $tweet->getUser()->getUsername());
    }
}
