<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
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
    public function new(Request $request, Club $club, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $team = new Team();
        $team->setClub($club);

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        $id = $request->attributes->get('id');

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $team->setPhoto($newFilename);
            }

            // ... persist the $product variable or any other work


            $team = $form->getData();

            $em = $doctrine->getManager();
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('app_club_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'id' => $id,
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        $id = $request->attributes->get('id');

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);

            return $this->redirectToRoute('app_team_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

//    #[Route('/delete/{id}', name: 'app_team_delete', methods: ['POST'])]
//    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
//    {
//
//        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->request->get('_token'))) {
//            $teamRepository->remove($team, true);
//        }
//
//        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
//    }

    #[Route('delete/{id}', name: 'app_team_delete')]
    public function delete($id, TeamRepository $teamRepository): Response
    {
        $team = $teamRepository->find($id);
        $teamRepository->remove($team, true);

        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
    }
}
