<?php

namespace App\Controller;

use App\Entity\Maze;
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
    public function configuration(Maze $maze, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MazeConfigurationType::class, $maze);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maze->setConfiguration($this->handlePoints($request->request));

            $entityManager->flush();

            return $this->redirectToRoute('app_maze');
        }

        return $this->render('maze/configuration.html.twig', [
            'form' => $form->createView(),
            'maze' => $maze,
        ]);
    }

    private function handlePoints(ParameterBag $request): array
    {
        $result = [];
        foreach ($request as $key => $value) {

            $keyRegex = 'maze_configuration_';

            if (str_contains($key, $keyRegex)) {
                $result[(int) str_replace($keyRegex, '', $key)] = $value;
            }
        }

        return $result;
    }
}
