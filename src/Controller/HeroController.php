<?php

namespace App\Controller;

use App\Entity\Hero;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HeroController extends AbstractController
{
    #[Route('/hero/{id}', name: 'hero_detail')]
    public function index(Hero $hero): Response
    {
        return $this->render('hero/index.html.twig', [
            'hero' => $hero,
        ]);
    }
}
