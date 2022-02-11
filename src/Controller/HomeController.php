<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\TarifsRepository;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EvenementRepository $evenementRepository): Response
    {
        if ($this->getUser() !== null) {
            if ($this->getUser()->getRoles()[0] == "ROLE_PROF") {
                $session = true;
                $events = $evenementRepository->findBy(['personnes' => $this->getUser()]);
            } else if ($this->getUser()->getRoles()[0] == "ROLE_ELEVE") {
                $session = true;
                $events = $this->getUser()->getParticipations();
            }
        } else {
            $session = false;
            $events = null;
        }


        return $this->render('home/index.html.twig', [
            'events' => $events,
            'session' => $session
        ]);
    }
}
