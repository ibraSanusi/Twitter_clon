<?php

namespace App\Controller;

use App\Entity\Tweet;
use App\Form\TweetType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

// class TweetController extends AbstractController
// {
//     #[Route('/tweet', name: 'app_tweet')]
//     public function post(Request $request, EntityManagerInterface $emi): Response
//     {
//         // GOOD - use of the normal security methods
//         $hasAccess = $this->isGranted('ROLE_USER');
//         $this->denyAccessUnlessGranted('ROLE_USER');

//         $tweet = new Tweet();
//         $form = $this->createForm(TweetType::class, $tweet);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $user = $this->getUser();
//             $currentDateTime = new \DateTime('now');

//             // Setear el usuario que hace la publicacion y la fecha
//             $tweet->setUser($user);
//             $tweet->setPublishDate($currentDateTime);

//             $emi->persist($tweet);
//             $emi->flush();

//             return new Response('Usuario insertado correctamente.');
//         }

//         return $this->render('tweet/index.html.twig', [
//             'controller_name' => 'TweetController',
//             'form' => $form,
//         ]);
//     }

//     // Mostrar todos los tweets
//     #[Route('/showalltweets', name: 'app_showAllTweets')]
//     public function show(UserRepository $ur): Response
//     {
//         $user = $ur->find($this->getUser());
//         $username = $user->getUsername();
//         $tweets = $user->getTweets();

//         return $this->render('tweet/showTweets.html.twig', [
//             'controller_name' => 'TweetController',
//             'username' => $username,
//             'tweets' => $tweets,
//         ]);
//     }

//     // Mostrar los tweets de los usuarios a los que sigue el usuario de la sesion
//     #[Route('/tweets', name: 'app_following_tweets')]
//     public function showFollowingTweets(UserRepository $ur): Response
//     {
//         $user = $ur->find($this->getUser());
//         $username = $user->getUsername();
//         $followingUsers = $user->getFollowers();

//         return $this->render('tweet/followingTweets.html.twig', [
//             'controller_name' => 'Home tweets',
//             'username' => $username,
//             'followingUsers' => $followingUsers
//         ]);
//     }
// }
