<?php

namespace App\Controller;

use App\Entity\Reunion;
use App\Form\ReunionType;
use App\Repository\PersonnesRepository;
use App\Repository\ReunionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReunionController extends AbstractController
{
    #[Route('/professeur/reunion', name: 'reunions')]
    public function show(): Response
    {
        return $this->render('reunion/show.html.twig');
    }

    #[Route('/professeur/reunion/create', name: 'create_reunion')]
    public function create_reunion(Request $request, EntityManagerInterface $em): Response
    {
        $reunion = new Reunion;
        $form = $this->createForm(ReunionType::class, $reunion);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            dd('ok');
            dd($form['professeurs']->getdata());
            $reunion->addProfesseur($this->getUser());
            $em->persist($reunion);
            $em->flush();
        }

        return $this->render('reunion/create.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
