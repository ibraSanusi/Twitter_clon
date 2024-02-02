<?php

namespace App\Controller;

use App\Entity\Follower;
use App\Form\FollowType;
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
            $follower->setFollowingId($user);
            $follower->setFollowingDate($currentDateTime);

            $emi->persist($follower);
            $emi->flush();

            return new Response('Se siguio correctamente');
        }

        return $this->render('user/follow.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form
        ]);
    }

    #[Route('/followed', name: 'app_followed')]
    public function showFollowers(UserRepository $ur): Response
    {
        $user = $ur->find($this->getUser());
        $username = $user->getUsername();
        $followers = $user->getFollowers();

        return $this->render('user/followers.html.twig', [
            'controller_name' => 'UserController',
            'username' => $username,
            'followers' => $followers
        ]);
    }
}
