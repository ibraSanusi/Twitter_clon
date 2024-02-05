<?php

namespace App\Controller;

use App\Entity\Follower;
use App\Entity\Like;
use App\Form\FollowType;
use App\Form\LikeType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    #[Route('/like', name: 'app_like')]
    public function likeTweet(UserRepository $ur, Request $request, EntityManagerInterface $emi): Response
    {
        // Formualario del like al tweet
        $like = new Like();
        $form = $this->createForm(LikeType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentDateTime = new \DateTime('now');
            $user = $this->getUser();

            $like->setUser($user);
            $like->setTweet($form->get('tweetId')->getData());
            $like->setLikeDate($currentDateTime);

            $emi->persist($like);
            $emi->flush();

            $this->redirectToRoute('app_following');
        }

        $user = $ur->find($this->getUser());
        $username = $user->getUsername();
        $followingUsers = $user->getFollowers();

        return $this->render('user/likeTweet.html.twig', [
            'controller_name' => 'Like tweets',
            'username' => $username,
            'form' => $form,
            'followingUsers' => $followingUsers
        ]);
    }
}
