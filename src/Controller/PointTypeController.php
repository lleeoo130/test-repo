<?php

namespace App\Controller;

use App\Entity\PointType;
use App\Form\PointTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PointTypeController extends AbstractController
{
    #[Route('/admin/point/type', name: 'app_point_type_creator')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PointTypeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointType = $form->getData();

            $manager->persist($pointType);
            $manager->flush();
        }

        return $this->render('point_type/index.html.twig', [
            'pointTypes' => $manager->getRepository(PointType::class)->findAll(),
            'form' => $form->createView(),
        ]);
    }
}
