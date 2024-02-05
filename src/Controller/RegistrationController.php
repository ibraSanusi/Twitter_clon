<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            // return $this->redirectToRoute('_profiler_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    //     #[Route('/register', name: 'app_register')]
    //     public function register(Request $request): Response
    //     {
    //         $user = new User();
    //         $request = $this->transformJsonBody($request);

    //         $user->setUsername($request->get('username'));
    //         $user->setPassword(
    //             $this->userPasswordHasher->hashPassword(
    //                 $user,
    //                 $request->get('password'),
    //             )
    //         );

    //         $data = ['username' => $request->get('username'), 'password' => $request->get('password')];

    //         $response = json_encode($data, true);
    //         // dump($request->get('username'));

    //         $this->entityManager->persist($user);
    //         $this->entityManager->flush();
    //         // do anything else you need here, like send an email

    //         dump($response);

    //         return new Response($request);
    //     }

    //     #[Route('/prueba', name: 'app_prueba')]
    //     public function response(Request $request): Response
    //     {
    //         $request = $this->transformJsonBody($request);

    //         $user = ['email' => $request->get('email'), 'password' => $request->get('password'), 'remember' => $request->get('remember')];
    //         $reponse = json_encode($user, true);

    //         return new Response($reponse);
    //     }

    //     protected function transformJsonBody(Request $request)
    //     {
    //         $data = json_decode($request->getContent(), true);

    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             return null;
    //         }
    //         if ($data === null) {
    //             return $request;
    //         }

    //         $request->request->replace($data);

    //         return $request;
    //     }
}
