<?php

namespace App\Controller;

use App\Repository\AbsenceRepository;
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
        return $this->render('home/index.html.twig');
    }
}
