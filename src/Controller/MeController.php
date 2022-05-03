<?php

namespace App\Controller;

use App\Repository\PersonnesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MeController extends AbstractController
{
    public function __invoke()
    {
        // $email = $_POST['email'];
        // $password = $_POST['password'];

        // if (!empty($email) && !empty($password)) {
        //     if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        //         $userFind = $personnesRepository->findOneBy(['email' => $email]);

        //         if ($hasher->isPasswordValid($userFind, $password)) {
        //             return $userFind;
        //         }
        //     }
        // }

        return $this->getUser();
    }
}
