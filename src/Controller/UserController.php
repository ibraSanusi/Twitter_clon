<?php

namespace App\Controller;

use App\Entity\Follower;
use App\Entity\Like;
use App\Form\FollowType;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/follow', name: 'app_follow')]
    public function follow(Request $request, EntityManagerInterface $emi): Response
    {
        $follower = new Follower();
        $form = $this->createForm(FollowType::class, $follower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $currentDateTime = new \DateTime('now');

            // Setear el usuario que hace el seguimiento y el la fecha
            $follower->setFollower($user);
            $follower->setFollowingDate($currentDateTime);

            $emi->persist($follower);
            $emi->flush();

            return $this->redirectToRoute('app_following');
        }

        $username = $this->getUser();

        return $this->render('user/follow.html.twig', [
            'username' => $username->getUserIdentifier(),
            'form' => $form
        ]);
    }

    // Muestra los usuarios a los que sigue en usuario en sesion
    #[Route('/following', name: 'app_following')]
    public function showFollowings(UserRepository $ur): Response
    {
        $user = $ur->find($this->getUser());
        $username = $user->getUsername();
        $followingUsers = $user->getFollowers();

        return $this->render('user/following.html.twig', [
            'controller_name' => 'Siguiendo',
            'username' => $username,
            'followingUsers' => $followingUsers
        ]);
    }

    // Muestra los seguidores del usuario en sesion
    #[Route('/followers', name: 'app_followers')]
    public function showFollowers(UserRepository $ur): Response
    {
        $user = $ur->find($this->getUser());
        $username = $user->getUsername();
        $userFollowers = $user->getFollowing();

        return $this->render('user/followers.html.twig', [
            'controller_name' => 'Seguidores',
            'username' => $username,
            'userFollowers' => $userFollowers
        ]);
    }

    // Mostrar los tweets de los usuarios a los que sigue el usuario de la sesion
    #[Route('/tweets', name: 'app_following_tweets')]
    public function showFollowingTweets(UserRepository $ur): Response
    {
        $user = $ur->find($this->getUser());
        $username = $user->getUsername();
        $followingUsers = $user->getFollowers();

        return $this->render('user/followingTweets.html.twig', [
            'controller_name' => 'Home tweets',
            'username' => $username,
            'followingUsers' => $followingUsers
        ]);
    }

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

                $likeForms[$tweet->getId()] = $likeForm->createView();
            }
        }

        return $this->render('user/likeTweet.html.twig', [
            'controller_name' => 'Like tweets',
            'username' => $username,
            'likeForms' => $likeForms,
            'followingUsers' => $followingUsers
        ]);
    }
}
