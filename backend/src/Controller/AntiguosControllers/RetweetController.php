<?php

namespace App\Controller;

use App\Entity\Retweet;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// class RetweetController extends AbstractController
// {
//     // Dar retweet a los tweets de los usuarios a los que sigue
//     // Controller con reentrada
//     #[Route('/retweet', name: 'app_retweet')]
//     public function retweet(UserRepository $ur, Request $request, EntityManagerInterface $emi, TweetRepository $tr): Response
//     {
//         $user = $ur->find($this->getUser());
//         $username = $user->getUsername();
//         $followingUsers = $user->getFollowers();

//         $retweetForms = [];

//         foreach ($followingUsers as $following) {
//             $tweets = $following->getFollowing()->getTweets();
//             foreach ($tweets as $tweet) {
//                 $reweet = new Retweet();

//                 $retweetForm = $this->createFormBuilder()
//                     ->setAction($this->generateUrl('app_retweet'))
//                     ->setMethod('POST')
//                     ->add('tweet', HiddenType::class, [
//                         'data' => $tweet->getId()
//                     ])
//                     ->add('retweet', SubmitType::class)
//                     ->getForm();

//                 $retweetForm->handleRequest($request); // Procesar el formulario de like

//                 if ($retweetForm->isSubmitted() && $retweetForm->isValid()) {
//                     $currentDateTime = new \DateTime('now');
//                     $user = $this->getUser();

//                     $tweetId = $retweetForm->get('tweet')->getData();

//                     $reweet->setTweet($tr->find($tweetId));
//                     $reweet->setUser($user);
//                     $reweet->setRetweetDate($currentDateTime);

//                     $emi->persist($reweet);
//                     $emi->flush();

//                     return $this->redirectToRoute('app_following'); // Redirigir después de procesar el like
//                 }

//                 // Aqui se crean vistas de formularios independientes
//                 $retweetForms[$tweet->getId()] = $retweetForm->createView();
//             }
//         }

//         return $this->render('retweet/retweet.html.twig', [
//             'controller_name' => 'Retweets',
//             'username' => $username,
//             'retweetForms' => $retweetForms,
//             'followingUsers' => $followingUsers
//         ]);
//     }
// }
