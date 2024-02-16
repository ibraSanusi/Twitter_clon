<?php

namespace App\Controller;

use App\Entity\Like;
use App\Repository\TweetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_like')]
class ApiLikeController extends AbstractController
{
    // Dar like a un tweet
    #[Route('/like/tweet', name: 'app_like_tweet', methods: ['POST'])]
    public function likeTweet(Request $request, EntityManagerInterface $emi, TweetRepository $tr): JsonResponse
    {
        // Recupera los datos de la request
        // Crear el like
        // Buscar el tweet en el repositorio y vincular el like al tweet
        $data = json_decode($request->getContent(), true);

        $like = new Like();

        $tweetId = $data['tweetId'];
        $user = $this->getUser();
        $currentDateTime = new \DateTime('now');
        $tweet = $tr->find($tweetId);

        $like->setTweet($tweet);
        $like->setUser($user);
        $like->setLikeDate($currentDateTime);

        $emi->persist($like);
        $emi->flush();

        return new JsonResponse('Like a ' . $tweet->getContent() . ' exitosamente', Response::HTTP_CREATED);
    }
}
