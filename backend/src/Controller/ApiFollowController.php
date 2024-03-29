<?php

namespace App\Controller;

use App\Entity\Follower;
use App\Entity\User;
use App\Repository\FollowerRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_follow')]
class ApiFollowController extends AbstractController
{
    // Seguir a otros usuarios
    #[Route('/follow', name: 'app_follow', methods: ['POST'])]
    public function follow(Request $request, EntityManagerInterface $emi, UserRepository $ur): Response
    {
        // Crear el follow
        // Capturar la respuesta y setear los atributos del usuario necesarios (usuario seguido)
        // Persistir el nuevo usuario
        $data = json_decode($request->getContent(), true);
        $followingId = $data['followingId'];
        $followingUser = $ur->find($followingId);

        $currentDateTime = new \DateTime('now');

        $follower = new Follower();
        $follower->setFollowing($followingUser);
        $follower->setFollower($this->getUser());
        $follower->setFollowingDate($currentDateTime);

        $emi->persist($follower);
        $emi->flush();

        return new JsonResponse('El usuario ' . $this->getUser()->getUserIdentifier() . ' siguo correctamente a: ' . $followingUser->getUsername() . ' con id: ' . $followingUser->getId(), Response::HTTP_ACCEPTED);
    }

    // Dejar de seguir a otros usuarios
    #[Route('/unfollow', name: 'app_unfollow', methods: ['POST'])]
    public function unfollow(Request $request, EntityManagerInterface $emi, UserRepository $ur, FollowerRepository $fr): Response
    {
        // Buscar el follow y eliminarlo
        $data = json_decode($request->getContent(), true);
        $followingId = $data['followingId'];
        $followingUser = $ur->find($followingId);

        $user = $this->getUser();
        if (!$user instanceof User) return null;

        $followerId = $user->getId();

        $followId = $fr->getFollowId($followerId, $followingId);
        $follow = $fr->find($followId);

        $emi->remove($follow);
        $emi->flush();

        return new JsonResponse('El usuario ' . $this->getUser()->getUserIdentifier() . ' a dejado de seguir a: ' . $followingUser->getUsername() . ' con id: ' . $followingUser->getId(), Response::HTTP_ACCEPTED);
    }

    // Sacar a los usuarios a los que sigue el usuario en sesion
    #[Route('/users/following/', name: 'app_following_users', methods: ['GET'])]
    public function showFollowings(UserRepository $ur): Response
    {
        $user = $ur->find($this->getUser());
        // De la tabla follower sacamos los usuarios que siguen (follower_id)
        // De esos usuarios que siguen hay que sacar a los usuarios a los que siguen
        $followersUsers = $user->getFollowers();

        $followingUsers = [];
        // Convertir los objetos de usuario a json
        foreach ($followersUsers as $user) {
            $userFollowing = $user->getFollowing();
            $followingUsers[] = [
                'id' => $userFollowing->getId(),
                'username' => $userFollowing->getUsername(),
            ];
        }

        return new JsonResponse(['following' => $followingUsers]);
    }

    // Muestra los seguidores del usuario en sesion
    #[Route('/users/followers', name: 'app_followers_users', methods: ['GET'])]
    public function showFollowers(UserRepository $ur): Response
    {
        $user = $ur->find($this->getUser());
        // De la tabla follower sacamos los usuarios seguidos
        // De esos usuarios seguidos hay que sacar a los usuarios que me siguen
        $selfFollowedUsers = $user->getFollowing();

        $followers = [];
        // Convertir los objetos de usuario a json
        foreach ($selfFollowedUsers as $self) {
            $follower = $self->getFollower();
            $followers[] = [
                'id' => $follower->getId(),
                'username' => $follower->getUsername(),
            ];
        }

        return new JsonResponse(['followers' => $followers]);
    }

    // Devolver todos lo usuarios a los que no sigue el usuario en sesion
    #[Route('/recomendated/users', name: 'app_recomendated_users', methods: ['GET'])]
    public function getNonFollowingUsers(UserRepository $ur): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) return null;

        $userId = $user->getId();

        $nonFollowingUsers = $ur->getNonFollowingUsers($userId);

        $recomendatedUsers = [];

        foreach ($nonFollowingUsers as $recomendatedUser) {
            $recomendatedUsers[] = [
                'id' => $recomendatedUser['id'],
                'username' => $recomendatedUser['username'],
                'roles' => $recomendatedUser['roles'],
                'followed' => false,
            ];
        }

        return new JsonResponse($recomendatedUsers);
    }

    // Devolver top 5 usuarios mas seguidos
    #[Route('/most/followed', name: 'most_followed')]
    public function getTopFiveFollowed(FollowerRepository $fr, UserRepository $ur): JsonResponse
    {
        // Obtener todos los usuarios del repositorio
        $allUsers = $ur->findAll();

        $responseJson = [];

        foreach ($allUsers as $user) {
            $responseJson[] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'followersCount' => count($user->getFollowing()), // Tenemos que sacar cuantas veces sale el id de ese usuario en following
            ];
        }

        return new JsonResponse($responseJson, Response::HTTP_ACCEPTED);
    }
}
