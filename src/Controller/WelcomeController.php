<?php

namespace App\Controller;

use App\Repository\MazeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    public function index(MazeRepository $mazeRepository): Response
    {
        return $this->render('welcome/index.html.twig', [
            'user' => $this->getUser(),
            'mazes' => $mazeRepository->findAll(),
        ]);
    }
}
