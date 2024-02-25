<?php

namespace App\Controller;

use App\Entity\LikeComment;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\LikeCommentRepository;
use App\Repository\LikeRepository;
use App\Repository\TweetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_comment')]
class ApiLikeCommentController extends AbstractController
{
    // Dar like a un comentario
    #[Route('/like/comment', name: 'app_like_comment', methods: ['POST'])]
    public function like(Request $request, EntityManagerInterface $emi, CommentRepository $cr): JsonResponse
    {
        // Recupera los datos de la request
        // Crear un likeComment
        // Buscar el comentario en el repositorio y vincular el like al comentario
        $data = json_decode($request->getContent(), true);

        $likeComment = new LikeComment();

        $commentId = $data['commentId'];
        $user = $this->getUser();
        $currentDateTime = new \DateTime('now');
        $comment = $cr->find($commentId);

        $likeComment->setComment($comment);
        $likeComment->setUser($user);
        $likeComment->setCreatedAt($currentDateTime);

        $emi->persist($likeComment);
        $emi->flush();

        return new JsonResponse('Like a ' . $comment->getContent() . ' exitosamente', Response::HTTP_CREATED);
    }

    // Eliminar el like de un comentario
    #[Route('/delete/comment/like', name: 'app_delete_comment_like', methods: ['POST'])]
    public function deleteLike(EntityManagerInterface $emi, Security $security, Request $request, LikeCommentRepository $lcr): JsonResponse
    {
        $user = $security->getUser();

        // Verificar si el usuario está autenticado
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // Recuperar los datos de la solicitud
        $data = json_decode($request->getContent(), true);
        $commentId = $data['commentId'];

        // Buscar el like del comentario
        $likeComment = $lcr->getLikeId($user->getId(), $commentId);

        // Verificar si el like del comentario existe
        if (!$likeComment) {
            return new JsonResponse(['error' => 'El like del comentario no existe'], Response::HTTP_NOT_FOUND);
        }

        // Eliminar el like del comentario
        $emi->remove($likeComment);
        $emi->flush();

        return new JsonResponse('Like del comentario eliminado correctamente.', Response::HTTP_OK);
    }
}
