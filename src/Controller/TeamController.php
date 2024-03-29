<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Team;
use App\Entity\TrainingPresence;
use App\Entity\User;
use App\Form\TeamType;
use App\Form\TrainingPresenceType;
use App\Repository\TeamRepository;
use App\Repository\TrainingRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/team')]
class TeamController extends AbstractController
{
    #[Route('/', name: 'app_team_index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new', name: 'app_team_new', methods: ['GET', 'POST'])]
    public function new($id, Request $request, Club $club, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $team = new Team();

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('photo')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                $team->setPhoto($newFilename);
                $team->setClub($club);
            }
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('app_club_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_show', methods: ['GET'])]
    public function show(Team $team, UserRepository $userRepository): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/trainings', name: 'app_team_trainings', methods: ['GET'])]
    public function trainings($id, Team $team, Request $request, UserRepository $userRepository, TrainingRepository $trainingRepository): Response
    {
        $trainings = $trainingRepository->findAllTrainingsOfteamOrderByDate($team);

        return $this->render('team/trainings.html.twig', [
            'trainings' => $trainings,
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit($id, Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);

            return $this->redirectToRoute('app_team_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('delete/{id}', name: 'app_team_delete')]
    public function delete($id, TeamRepository $teamRepository): Response
    {
        $team = $teamRepository->find($id);
        $teamRepository->remove($team, true);

        $this->addFlash('success', 'Votre équipe a été supprimé avec succès.');

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
