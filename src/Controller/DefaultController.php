<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    #[Route('/dashboard_user', name: 'app_default_user')]
    public function indexUser(): Response
    {
        return $this->render('default/user.html.twig');
    }

    #[Route('/cyberfolio/{id}', name: 'app_home')]
    public function home(User $user): Response
    {
        $profile = $user->getProfile();
        $projects = $user->getProjects();
        return $this->render('default/home.html.twig', [
            'user' => $user,
            'profile' => $profile,
            'projects' => $projects,
        ]);
    }


}
