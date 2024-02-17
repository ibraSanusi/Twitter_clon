<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\User;
use App\Repository\LikeRepository;
use App\Repository\TweetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_like')]
class ApiLikeController extends AbstractController
{
    // Dar like a un tweet
    #[Route('/like', name: 'app_like', methods: ['POST'])]
    public function like(Request $request, EntityManagerInterface $emi, TweetRepository $tr): JsonResponse
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

    // Dar like a un tweet
    #[Route('/delete/like', name: 'app_delete_like', methods: ['POST'])]
    public function deleteLike(EntityManagerInterface $emi, Security $security, Request $request, LikeRepository $lr): JsonResponse
    {
        $user = $security->getUser();

        // Verificar si el usuario está autenticado
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // Recuperar los datos de la solicitud
        $data = json_decode($request->getContent(), true);
        $tweetId = $data['tweetId'];

        // Buscar el like
        $like = $lr->getLikeId($user->getId(), $tweetId);

        // Verificar si el like existe
        if (!$like) {
            return new JsonResponse(['error' => 'El like no existe'], Response::HTTP_NOT_FOUND);
        }

        // Eliminar el like
        $emi->remove($like);
        $emi->flush();

        return new JsonResponse('Like eliminado correctamente.', Response::HTTP_OK);
    }
}
