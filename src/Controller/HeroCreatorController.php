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
        $form = $this->createForm(HeroType::class, new Hero());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedHero = $form->getData();
            $submittedHero->setLevel('1');
            /** @var $user */
            $user = $this->getUser();
            $user->setHero($submittedHero);

            $manager->persist($submittedHero);
            $manager->flush();

            return $this->redirectToRoute('app_welcome');
        }

        return $this->render('hero_creator/index.html.twig', [
            'form' => $form
        ]);
    }
}
