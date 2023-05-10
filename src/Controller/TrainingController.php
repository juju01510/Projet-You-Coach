<?php

namespace App\Controller;

use App\Entity\Training;
use App\Entity\TrainingPresence;
use App\Form\TrainingPresenceType;
use App\Form\TrainingType;
use App\Repository\TrainingPresenceRepository;
use App\Repository\TrainingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/training')]
class TrainingController extends AbstractController
{
    #[Route('/', name: 'app_training_index', methods: ['GET'])]
    public function index(TrainingRepository $trainingRepository): Response
    {
        return $this->render('training/index.html.twig', [
            'trainings' => $trainingRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_training_new', methods: ['GET', 'POST'])]
    public function new($id, Request $request, TrainingRepository $trainingRepository): Response
    {
        $training = new Training();
        $form = $this->createForm(TrainingType::class, $training, [
            'idClub' => $this->getUser()->getClub()->getId(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trainingRepository->save($training, true);

            return $this->redirectToRoute('app_team_trainings', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('training/new.html.twig', [
            'training' => $training,
            'form' => $form,
            'teamId' => $id,
        ]);
    }

    #[Route('/{id}', name: 'app_training_show', methods: ['GET', 'POST'])]
    public function show(Training $training, UserRepository $userRepository, TrainingPresenceRepository $trainingPresenceRepository, Request $request, EntityManagerInterface $em): Response
    {
        $teamId = $training->getTeam()->getId();

        $players = $userRepository->findPresentPlayersByTraining($training);

        $presence = new TrainingPresence();
        $form = $this->createForm(TrainingPresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $presence->setPlayer($this->getUser());
            $presence->setTraining($training);
            $em->persist($presence);
            $em->flush();
            return $this->redirectToRoute('app_team_trainings', ['id' => $teamId], Response::HTTP_SEE_OTHER);
        }

        $this->redirectToRoute('app_home');

        return $this->render('training/show.html.twig', [
            'players' => $players,
            'formPresense' => $form->createView(),
            'training' => $training,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_training_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Training $training, TrainingRepository $trainingRepository): Response
    {
        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trainingRepository->save($training, true);

            return $this->redirectToRoute('app_training_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('training/edit.html.twig', [
            'training' => $training,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_training_delete', methods: ['POST'])]
    public function delete(Request $request, Training $training, TrainingRepository $trainingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$training->getId(), $request->request->get('_token'))) {
            $trainingRepository->remove($training, true);
        }

        return $this->redirectToRoute('app_training_index', [], Response::HTTP_SEE_OTHER);
    }
}
