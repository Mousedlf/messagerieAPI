<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $manager,UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        $json = $request->getContent();
        $user = $serializer->deserialize($json, User::class, 'json');

        # if password
        # if username

        // encode the plain password
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );

        $taken = $userRepository->findOneBy(['username'=> $user->getUsername()]);
            if (!$taken){

                # creer un profile lors création user

                $manager->persist($user);
                $manager->flush();

                return $this->json($user, 200);
            } else {
                return $this->json("username taken", 401);
            }

    }
}
