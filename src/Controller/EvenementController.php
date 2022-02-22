<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Absence;
use App\Form\EventType;
use App\Entity\Evenement;
use App\Entity\Inscription;
use App\Repository\TypeRepository;
use App\Repository\EvenementRepository;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $event = new Evenement();
        $form = $this->createForm(EventType::class, $event, ['user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

        $inscription = new Inscription();
        $inscription->setEleves($this->getUser());
        $inscription->setEvenements($event);
        $inscription->setAbsence(false);

        $em->persist($inscription);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/log/type/professeur/{id}/show-participant', name: 'detail')]
    public function participants($id, EvenementRepository $evenementRepository, InscriptionRepository $inscriptionRepository, EntityManagerInterface $em): Response
    {
        $event = $evenementRepository->findOneBy(['id' => $id]);
        $inscriptions = $inscriptionRepository->findBy(['evenements' => $event]);
        $absents = $inscriptionRepository->findBy(['Absence' => 1]);

        return $this->render('evenement/show_participant.html.twig', [
            'event' => $event,
            'inscriptions' => $inscriptions
        ]);
    }

    #[Route('/log/type/professeur/{id}/edit_event', name: 'edit_event')]
    public function edit_event($id, EvenementRepository $evenementRepository, EntityManagerInterface $em, Request $request): Response
    {
        $selected_event = $evenementRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(EventType::class, $selected_event);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('evenement/edit.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    #[Route('/log/type/professeur/del_event', name: 'del_event')]
    public function del_event(EvenementRepository $evenementRepository, EntityManagerInterface $em, Request $request): Response
    {
        $event = $evenementRepository->findOneBy(['id' => $_POST['event']]);
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/log/type/professeur/absence', name: 'absence')]
    public function absence(EvenementRepository $evenementRepository, InscriptionRepository $inscriptionRepository, EntityManagerInterface $em, Request $request): Response
    {
        $event = $evenementRepository->findOneBy(['id' => $_POST['id']]);
        $inscription = $inscriptionRepository->findOneBy(['evenements' => $event]);

        $inscription->setAbsence(true);

        $em->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/log/type/professeur/{id}/remplacement', name: 'remplacement')]
    public function remplacement($id, EvenementRepository $evenementRepository, EntityManagerInterface $em, Request $request): Response
    {
        $selected_event = $evenementRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(EventType::class, $selected_event, ['user' => $this->getUser()])->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('evenement/replace.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
