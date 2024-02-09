<?php

namespace App\Controller;

use App\Entity\Like;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LikeController extends AbstractController
{
    // Dar likes a los tweets de los usuarios a los que sigue
    // Controller con reentrada
    #[Route('/like', name: 'app_like')]
    public function likeTweet(UserRepository $ur, Request $request, EntityManagerInterface $emi, TweetRepository $tr): Response
    {
        $user = $ur->find($this->getUser());
        $username = $user->getUsername();
        $followingUsers = $user->getFollowers();

        $likeForms = [];

        foreach ($followingUsers as $following) {
            $tweets = $following->getFollowing()->getTweets();
            foreach ($tweets as $tweet) {
                $like = new Like();

                $likeForm = $this->createFormBuilder()
                    ->setAction($this->generateUrl('app_like'))
                    ->setMethod('POST')
                    ->add('tweet', HiddenType::class, [
                        'data' => $tweet->getId()
                    ])
                    ->add('like', SubmitType::class)
                    ->getForm();

                $likeForm->handleRequest($request); // Procesar el formulario de like

                if ($likeForm->isSubmitted() && $likeForm->isValid()) {
                    $currentDateTime = new \DateTime('now');
                    $user = $this->getUser();

                    $tweetId = $likeForm->get('tweet')->getData();

                    $like->setTweet($tr->find($tweetId));
                    $like->setUser($user);
                    $like->setLikeDate($currentDateTime);

                    $emi->persist($like);
                    $emi->flush();

                    return $this->redirectToRoute('app_following'); // Redirigir después de procesar el like
                }

                // Aqui se crean vistas de formularios independientes
                $likeForms[$tweet->getId()] = $likeForm->createView();
            }
        }

        return $this->render('like/likeTweet.html.twig', [
            'controller_name' => 'Like tweets',
            'username' => $username,
            'likeForms' => $likeForms,
            'followingUsers' => $followingUsers
        ]);
    }
}
