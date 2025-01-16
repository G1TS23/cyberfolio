<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/project')]
final class ProjectController extends AbstractController
{
    #[Route(name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository, Security $security): Response
    {
        $user = $security->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        if ($isAdmin) {
            return $this->render('project/index.html.twig', [
                'projects' => $projectRepository->findAll(),
            ]);
        }
            return $this->render('project/index.html.twig', [
                'projects' => $projectRepository->findBy(['user' => $user]),
            ]);

    }

    #[Route('/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project, [
            'is_admin' => $isAdmin,
            'current_user' => $user,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($project);
            $entityManager->flush();
            /*foreach ($project->getTechnologies() as $technology) {
                $technology->addProject($project);
                $entityManager->persist($technology);
                $entityManager->flush();
            }*/

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project, Security $security): Response
    {
        $user = $security->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        if ($project->getUser() === $user || $isAdmin) {
            return $this->render('project/show.html.twig', [
                'project' => $project,
            ]);
        }
        return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        if ($project->getUser() !== $user && !$isAdmin) {
            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }


        $form = $this->createForm(ProjectType::class, $project, [
            'is_admin' => $isAdmin,
            'current_user' => $user,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
    }
}
