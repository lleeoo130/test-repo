<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MazeController extends AbstractController
{
    #[Route('/admin/mazes', name: 'app_maze')]
    public function index(): Response
    {
        return $this->render('maze/index.html.twig', []);
    }

    #[Route('/admin/mazes_creator', name: 'app_maze_creator')]
    public function creator(): Response
    {
        return $this->render('maze/creator.html.twig', []);
    }
}
