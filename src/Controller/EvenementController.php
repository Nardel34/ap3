<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EventType;
use App\Repository\EvenementRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    #[Route('/log/type', name: 'type')]
    public function type(TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findAll();
        return $this->render('evenement/type.html.twig', [
            'types' => $types
        ]);
    }

    #[Route('/log/type/{id}/show', name: 'eventByType')]
    public function eventByType($id, EvenementRepository $evenementRepository, TypeRepository $typeRepository): Response
    {
        $eventsByType = $evenementRepository->findBy(['type' => $id]);
        $type = $typeRepository->findOneBy(['id' => $id]);

        return $this->render('evenement/show.html.twig', [
            'eventsByType' => $eventsByType,
            'type' => $type
        ]);
    }

    #[Route('/log/type/professeur/createevent', name: 'create_event')]
    public function create(TypeRepository $typeRepository, Request $request, EntityManagerInterface $em): Response
    {
        $event = new Evenement;
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $event->setPersonnes($this->getUser());
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('evenement/create.html.twig', [
            'formView' => $form->createView()
        ]);
    }
    #[Route('/log/type/eleve/{id}/inscription', name: 'inscription')]
    public function inscription($id, EvenementRepository $evenementRepository, EntityManagerInterface $em): Response
    {
        $event = $evenementRepository->findOneBy(['id' => $id]);
        $event->addInscrit($this->getUser());
        $this->getUser()->addParticipation($event);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/log/type/professeur/{id}/show-participant', name: 'detail')]
    public function participants($id, EvenementRepository $evenementRepository, EntityManagerInterface $em): Response
    {
        $event = $evenementRepository->findOneBy(['id' => $id]);
        $participants = $event->getInscrits();

        return $this->render('evenement/show_participant.html.twig', [
            'event' => $event,
            'participants' => $participants
        ]);
    }
}
