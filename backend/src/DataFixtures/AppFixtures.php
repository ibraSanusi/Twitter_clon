<?php

namespace App\DataFixtures;

use App\Entity\Follower;
use App\Entity\Tweet;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $ur;

    public function __construct(UserPasswordHasherInterface $encoder, UserRepository $ur)
    {
        $this->encoder = $encoder;
        $this->ur = $ur;
    }

    public function load(ObjectManager $manager)
    {
        // Obtener el contenido del archivo JSON
        $jsonString = file_get_contents(__DIR__ . '/users.json');

        // Decodificar el JSON a un array asociativo
        $data = json_decode($jsonString, true);

        $usersData = $data['users'];
        $tweetsData = $data['tweets'];
        $followsData = $data['follows'];

        // Crear y persistir usuarios
        foreach ($usersData as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            // Asignar roles si es necesario
            $user->setRoles($userData['roles']);
            $passwordHashed = $this->encoder->hashPassword($user, $userData['password']);
            $user->setPassword($passwordHashed);
            $manager->persist($user);
        }

        // Hacer flush fuera del bucle para mejorar el rendimiento
        $manager->flush();

        // Crear y persistir tweets
        foreach ($tweetsData as $tweetData) {
            // Verificar si el userId está presente
            $userId = $tweetData['userId'];
            if (!$userId) {
                // Manejar el caso en que no haya userId definido
                throw new \Exception('El userId no está definido para el tweet: ' . $tweetData['content']);
            }

            // Obtener el usuario asociado al tweet
            $user = $this->ur->find($userId);
            if (!$user) {
                // Manejar el caso en que el usuario no se encuentra en la base de datos
                throw new \Exception('No se encontró el usuario con ID: ' . $userId . ' asociado al tweet: ' . $tweetData['content']);
            }

            // Crear y configurar el tweet
            $tweet = new Tweet();
            $tweet->setContent($tweetData['content']);
            $tweet->setPublishDate(new \DateTime($tweetData['publishDate']));
            $tweet->setUser($user);

            // Persistir el tweet
            $manager->persist($tweet);
        }

        // Hacer flush fuera del bucle para mejorar el rendimiento
        $manager->flush();

        // Crear relaciones de seguimiento entre usuarios
        foreach ($followsData as $followData) {
            $followerId = $followData['follower_id'];
            $followingId = $followData['following_id'];

            // Crear una relación de seguimiento para cada usuario a seguir
            $follower = $this->ur->find($followerId);
            $following = $this->ur->find($followingId);

            $followRelationship = new Follower();
            $followRelationship->setFollower($follower);
            $followRelationship->setFollowing($following);
            $followRelationship->setFollowingDate(new \DateTime());

            $manager->persist($followRelationship);
        }

        // Hacer flush fuera del bucle para mejorar el rendimiento
        $manager->flush();
    }
}
