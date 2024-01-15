<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\User;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    #[Route('/show/{id}', name: 'app_user_show_formation', methods: ['GET'])]
    public function show_formation(User $user)
    {
        return $this->render('home/show.html.twig', [
            'user' => $user,
        ]);
    }


    
}
