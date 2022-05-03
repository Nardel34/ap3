<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\LoginType;
use App\Form\SignupType;
use App\Entity\Personnes;
use App\Entity\Professeur;
use App\Form\SignupProfType;
use App\Repository\PersonnesRepository;
use App\Repository\TarifsRepository;
use DateTime;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Json;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        $form = $this->createForm(LoginType::class, ['email' => $utils->getLastUsername()]);

        return $this->render('security/login.html.twig', [
            'formView' => $form->createView(),
            'error' => $utils->getLastAuthenticationError()
        ]);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST', 'GET'])]
    public function apiLogin(PersonnesRepository $personnesRepository, UserPasswordHasherInterface $hasher)
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $userFind = $personnesRepository->findOneBy(['email' => $email]);

                if ($hasher->isPasswordValid($userFind, $password)) {
                    return $this->json([
                        'id' => $userFind->getId(),
                        'email' => $userFind->getEmail(),
                        'nom' => $userFind->getNom(),
                        'prenom' => $userFind->getPrenom(),
                        'roles' => $userFind->getRoles()
                    ]);
                }
            }
        }
    }

    #[Route('/logout', name: 'security_logout')]
    public function logout()
    {
    }

    #[Route('/signup_professeur', name: 'security_signup_prof')]
    public function Signup_prof(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em)
    {
        $user = new Personnes;
        $form = $this->createForm(SignupType::class, $user);
        $form->handleRequest($request);

        $confException = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_PROF"])
                ->setExpPro($_POST['exp'])
                ->setDiplome($_POST['diplome']);

            if ($_POST['confirm_password'] == $form['password']->getdata()) {
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('security_login');
            } else {
                $confException = 'Les 2 mot de passe ne corresponde pas';
            }
        }

        return $this->render('security/signup_prof.html.twig', [
            'formView' => $form->createView(),
            'confException' => $confException
        ]);
    }

    #[Route('/signup_eleve', name: 'security_signup_eleve')]
    public function Signup_eleve(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em, TarifsRepository $tarifsRepository)
    {
        $user = new Personnes;
        $form = $this->createForm(SignupType::class, $user);
        $form->handleRequest($request);

        $confException = '';
        $tarifException = '';

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_ELEVE"]);

            $user->setDateEntree(date_format(date_create('now'), 'd-m-Y'));

            if ($_POST['tarifchoice'] == "option1") {
                $user->setTarifs($tarifsRepository->findOneBy(['Prix' => '500']));

                if ($_POST['confirm_password'] == $form['password']->getdata()) {
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute('security_login');
                } else {
                    $confException = 'Les 2 mot de passe ne corresponde pas';
                }
            } else if ($_POST['tarifchoice'] == "option2") {
                $user->setTarifs($tarifsRepository->findOneBy(['Prix' => '1000']));

                if ($_POST['confirm_password'] == $form['password']->getdata()) {
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute('security_login');
                } else {
                    $confException = 'Les 2 mot de passe ne corresponde pas';
                }
            } else {
                $tarifException = 'Veuillez choisir un abonnement';
            }
        }

        return $this->render('security/signup_eleve.html.twig', [
            'formView' => $form->createView(),
            'confException' => $confException,
            'tarifException' => $tarifException
        ]);
    }
}
