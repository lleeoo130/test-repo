<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Form\HeroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HeroCreatorController extends AbstractController
{
    #[Route('/hero_creator', name: 'hero_creator')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        $newHero = (new Hero())->setUser($user);

        $form = $this->createForm(HeroType::class, $newHero);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedHero = $form->getData();
            $submittedHero->setLevel('1');

            $manager->persist($submittedHero);
            $manager->flush();

            return $this->redirectToRoute('app_welcome');
        }

        return $this->render('hero_creator/index.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }
}
