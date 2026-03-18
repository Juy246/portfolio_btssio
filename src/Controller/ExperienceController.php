<?php

namespace App\Controller;

use App\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExperienceController extends AbstractController
{
    #[Route('/experience', name: 'app_experience')]
    public function index(ExperienceRepository $experienceRepository): Response
    {
        $educations = $experienceRepository->findBy(
            ['type' => 'experience']
        );

        $experiences = $experienceRepository->findBy(
            ['type' => 'professionnel']
        );

        return $this->render('experience/index.html.twig', [
            'educations' => $educations,
            'experiences' => $experiences,
        ]);
    }
}
