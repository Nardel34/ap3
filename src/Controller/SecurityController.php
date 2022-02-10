<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\LoginType;
use App\Form\SignupType;
use App\Entity\Personnes;
use App\Entity\Professeur;
use App\Form\SignupProfType;
use App\Repository\TarifsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        $form = $this->createForm(LoginType::class, ['email' => $utils->getLastUsername()]);

        if ($form->isSubmitted()) {
            if ($this->getUser()->getRoles() == [0 => "ROLE_PROF", 1 => "ROLE_USER"]) {
                return $this->redirectToRoute('index_prof');
            } else if ($this->getUser()->getRoles() == [0 => "ROLE_ELEVE", 1 => "ROLE_USER"]) {
                return $this->redirectToRoute('index_eleve');
            }
        }

        return $this->render('security/login.html.twig', [
            'formView' => $form->createView(),
            'error' => $utils->getLastAuthenticationError()
        ]);
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

        if ($form->isSubmitted()) {
            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_PROF"])
                ->setExpPro($_POST['exp'])
                ->setDiplome($_POST['diplome']);
            $em->persist($user);
            $em->flush();

            if ($_POST['confirm_password'] == $form['password']->getdata()) {
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('security_login');
            }
        }

        return $this->render('security/signup_prof.html.twig', [
            'formView' => $form->createView()
        ]);
    }
    #[Route('/signup_eleve', name: 'security_signup_eleve')]
    public function Signup_eleve(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em, TarifsRepository $tarifsRepository)
    {
        $user = new Personnes;
        $form = $this->createForm(SignupType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_ELEVE"]);

            $user->setDateEntree(date_format(date_create('now'), 'd-m-Y'));
            if ($_POST['tarifchoice'] == "option1") {
                $user->setTarifs($tarifsRepository->findOneBy(['id' => 7]));
            } else {
                $user->setTarifs($tarifsRepository->findOneBy(['Id_tarifs' => 8]));
            }
            if ($_POST['confirm_password'] == $form['password']->getdata()) {
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('security_login');
            }
        }

        return $this->render('security/signup_eleve.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
