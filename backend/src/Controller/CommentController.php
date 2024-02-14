<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    // Hacer un comentario a un tweet
    // Controller con reentrada
    #[Route('/comment', name: 'app_comment')]
    public function comment(UserRepository $ur, Request $request, EntityManagerInterface $emi, TweetRepository $tr): Response
    {
        $user = $ur->find($this->getUser());
        $username = $user->getUsername();
        $followingUsers = $user->getFollowers();

        $commentForms = [];

        foreach ($followingUsers as $following) {
            $tweets = $following->getFollowing()->getTweets();
            foreach ($tweets as $tweet) {
                $comment = new Comment();

                $commentFrom = $this->createFormBuilder()
                    ->setAction($this->generateUrl('app_comment'))
                    ->setMethod('POST')
                    ->add('tweet', HiddenType::class, [
                        'data' => $tweet->getId()
                    ])
                    ->add('comment', TextType::class)
                    ->add('post', SubmitType::class)
                    ->getForm();

                $commentFrom->handleRequest($request); // Procesar el formulario de like

                if ($commentFrom->isSubmitted() && $commentFrom->isValid()) {
                    $currentDateTime = new \DateTime('now');
                    $user = $this->getUser();

                    $tweetId = $commentFrom->get('tweet')->getData();
                    $content = $commentFrom->get('comment')->getData();

                    $comment->setContent($content);
                    $comment->setTweet($tr->find($tweetId));
                    $comment->setAuthor($user);
                    $comment->setCreatedAt($currentDateTime);

                    $emi->persist($comment);
                    $emi->flush();

                    return $this->redirectToRoute('app_following'); // Redirigir después de procesar el like
                }

                // Aqui se crean vistas de formularios independientes
                $commentForms[$tweet->getId()] = $commentFrom->createView();
            }
        }

        return $this->render('comment/commentTweet.html.twig', [
            'controller_name' => 'Comment',
            'username' => $username,
            'commentForms' => $commentForms,
            'followingUsers' => $followingUsers
        ]);
    }

    // Mostrar todos los comentarios. Comentarios de tweets y de comentarios
    // Controller con reentrada
    #[Route('/show/comments', name: 'app_show_comments')]
    public function showComments(UserRepository $ur, Request $request, EntityManagerInterface $emi, TweetRepository $tr): Response
    {
        $user = $ur->find($this->getUser());
        $username = $user->getUsername();
        $followingUsers = $user->getFollowers();

        $commentForms = [];

        foreach ($followingUsers as $following) {
            $tweets = $following->getFollowing()->getTweets();
            foreach ($tweets as $tweet) {
                $comment = new Comment();

                $commentFrom = $this->createFormBuilder()
                    ->setAction($this->generateUrl('app_comment'))
                    ->setMethod('POST')
                    ->add('tweet', HiddenType::class, [
                        'data' => $tweet->getId()
                    ])
                    ->add('post', SubmitType::class)
                    ->getForm();

                $commentFrom->handleRequest($request); // Procesar el formulario de like

                if ($commentFrom->isSubmitted() && $commentFrom->isValid()) {
                    $currentDateTime = new \DateTime('now');
                    $user = $this->getUser();

                    $tweetId = $commentFrom->get('tweet')->getData();
                    $content = $commentFrom->get('comment')->getData();

                    $comment->setContent($content);
                    $comment->setTweet($tr->find($tweetId));
                    $comment->setAuthor($user);
                    $comment->setCreatedAt($currentDateTime);

                    $emi->persist($comment);
                    $emi->flush();

                    return $this->redirectToRoute('app_following'); // Redirigir después de procesar el like
                }

                // Aqui se crean vistas de formularios independientes
                $commentForms[$tweet->getId()] = $commentFrom->createView();
            }
        }

        return $this->render('comment/showComments.html.twig', [
            'controller_name' => 'Show Comments',
            'username' => $username,
            'commentForms' => $commentForms,
            'followingUsers' => $followingUsers
        ]);
    }
}
