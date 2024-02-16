<?php

namespace App\Controller;

use App\Entity\Retweet;
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

#[Route('/api', name: 'app_retweet_api')]
class ApiRetweetController extends AbstractController
{
    // Dar retweet a los tweets de los usuarios a los que sigue el usuario en sesion
    // Controller con reentrada
    #[Route('/retweet', name: 'app_retweet')]
    public function retweet(UserRepository $ur, Request $request, EntityManagerInterface $emi, TweetRepository $tr): Response
    {
        $reweet = new Retweet();

        $data = json_decode($request->getContent(), true);
        $tweetId = $data['tweetId'];

        $user = $ur->find($this->getUser());
        $user = $this->getUser();

        $currentDateTime = new \DateTime('now');

        $tweet = $tr->find($tweetId);
        $reweet->setTweet($tweet);
        $reweet->setUser($user);
        $reweet->setRetweetDate($currentDateTime);

        $emi->persist($reweet);
        $emi->flush();


        return new JsonResponse('El usuario ' . $tweet->getUser()->getUsername() . ' ha dado retweet al tweet ' . $tweet->getContent(), Response::HTTP_ACCEPTED);
    }
}
