<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\InscriptionRepository;
use App\Repository\PersonnesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiController extends AbstractController
{
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

    #[Route('/api/eventuser/{id}', name: 'eventuserapi', methods: ['GET'])]
    public function eventuserapi($id, EvenementRepository $evenementRepository)
    {
        $eventfind = $evenementRepository->findBy(['personnes' => $id]);

        $events = [];

        foreach ($eventfind as $item) {
            $false_entity = [];
            $false_entity['type'] = $item->getType()->getNomType();
            $false_entity['lieu'] = $item->getLieu()->getAdresseLieu();
            $false_entity['date'] = date_format($item->getDateEvent(), "d/m/Y");

            array_push($events, $false_entity);
        }

        return $this->json([
            'events' => $events
        ]);
    }

    #[Route('/api/registration/{id}', name: 'registeruserapi')]
    public function registrationapi($id, InscriptionRepository $inscriptionRepository)
    {
        $registerfind = $inscriptionRepository->findBy(['eleves' => $id]);

        $events = [];

        foreach ($registerfind as $item) {
            $false_entity = [];
            $false_entity['type'] = $item->getEvenements()->getType()->getNomType();
            $false_entity['lieu'] = $item->getEvenements()->getLieu()->getAdresseLieu();
            $false_entity['date'] = date_format($item->getEvenements()->getDateEvent(), "d/m/Y");

            array_push($events, $false_entity);
        }

        return $this->json([
            'events' => $events
        ]);
    }
}
