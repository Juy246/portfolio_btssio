<?php

namespace App\Controller;

use App\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExperienceController extends AbstractController
{
    #[Route('/experience', name: 'app_formation')]
    public function index(ExperienceRepository $formationRepository): Response
    {
        $formations = $formationRepository->findBy(
            ['type' => 'experience']
        );

        $experiences = $formationRepository->findBy(
            ['type' => 'professionnel']
        );

        return $this->render('experience/index.html.twig', [
            'formations' => $formations,
            'experiences' => $experiences,
        ]);
    }
}
