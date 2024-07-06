<?php

namespace App\Controller;

use App\Entity\Factory\PointFactory;
use App\Entity\Hero;
use App\Entity\Maze;
use App\Entity\Parser\MazeConfigurationParser;
use App\Form\MazeConfigurationType;
use App\Form\MazeType;
use App\Repository\MazeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MazeController extends AbstractController
{
    #[Route('/admin/mazes', name: 'app_maze')]
    public function index(MazeRepository $mazeRepository): Response
    {
        return $this->render('maze/index.html.twig', [
            'mazes' => $mazeRepository->findAll(),
        ]);
    }

    #[Route('/admin/maze_creator', name: 'app_maze_creator')]
    public function creator(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MazeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var @Maze $maze */
            $maze = $form->getData();
            $maze->setSize(5);

            $entityManager->persist($maze);
            $entityManager->flush();

            return $this->redirectToRoute('app_maze_configuration', ['id' => $maze->getId()]);
        }

        return $this->render('maze/creator.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/maze_configuration/{id}', name: 'app_maze_configuration')]
    public function configuration(
        Maze $maze,
        Request $request,
        EntityManagerInterface $entityManager,
        PointFactory $pointFactory,
        MazeConfigurationParser $parser
    ): Response
    {
        $form = $this->createForm(MazeConfigurationType::class, $maze);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointsArray = $parser->parse($request->request);

            foreach ($pointsArray as $coordinate => $type) {
                $point = $pointFactory->createFromConfigurationArray($maze, [$coordinate => $type]);

                $entityManager->persist($point);
                $maze->addPoint($point);
            }

            $entityManager->persist($maze);
            $entityManager->flush();

            return $this->redirectToRoute('app_maze');
        }

        return $this->render('maze/configuration.html.twig', [
            'form' => $form->createView(),
            'maze' => $maze,
        ]);
    }

    #[Route('/playing/maze/{id}', name: 'app_playing_maze')]
    public function play(Maze $maze): Response
    {
        /** @var Hero */
        $hero = $this->getUser()->getHero();

        if (is_null($hero->getCurrentPoint())) {
            $hero->setCurrentPoint($maze->getPoints()->get(38));
        }

        return $this->render('maze/playing.html.twig', [
            'maze' => $maze,
            'hero' => $hero,
        ]);
    }
}
