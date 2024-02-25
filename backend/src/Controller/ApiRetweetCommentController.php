<?php

namespace App\Controller;

use App\Entity\RetweetComment;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\RetweetCommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app_api_retweet_comment')]
class ApiRetweetCommentController extends AbstractController
{
    // Dar retweet al comentario
    #[Route('/retweet/comment', name: 'app_retweet_comment')]
    public function retweetComment(UserRepository $ur, Request $request, EntityManagerInterface $emi, CommentRepository $cr): Response
    {
        $reweetComment = new RetweetComment();

        $data = json_decode($request->getContent(), true);
        $commentId = $data['commentId'];

        $user = $ur->find($this->getUser());
        $user = $this->getUser();

        $currentDateTime = new \DateTime('now');

        $comment = $cr->find($commentId);
        $reweetComment->setComment($comment);
        $reweetComment->setUser($user);
        $reweetComment->setCreatedAt($currentDateTime);

        $emi->persist($reweetComment);
        $emi->flush();


        return new JsonResponse('El usuario ' . $comment->getAuthor()->getUsername() . ' ha dado retweet al comentario ' . $comment->getContent(), Response::HTTP_ACCEPTED);
    }

    // Quitar retweet al comentario
    #[Route('/delete/retweet/comment', name: 'app_delete_retweet_comment', methods: ['POST'])]
    public function deleteCommentRetweet(EntityManagerInterface $emi, Security $security, Request $request, RetweetCommentRepository $rcr): JsonResponse
    {
        $user = $security->getUser();

        // Verificar si el usuario está autenticado
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // Recuperar los datos de la solicitud
        $data = json_decode($request->getContent(), true);
        $commentId = $data['commentId'];

        // Buscar el retweet del comentario
        $retweetComment = $rcr->getRetweetId($user->getId(), $commentId);

        // Verificar si el retweet del comentario existe
        if (!$retweetComment) {
            return new JsonResponse(['error' => 'El retweetComment no existe'], Response::HTTP_NOT_FOUND);
        }

        // Eliminar el like
        $emi->remove($retweetComment);
        $emi->flush();

        return new JsonResponse('Retweet del comentario ' . $commentId . ' ha sido eliminado correctamente.', Response::HTTP_OK);
    }
}
