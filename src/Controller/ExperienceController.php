<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExperienceController extends AbstractController
{
    #[Route('/experiences', name: 'app_experience_index', methods: ['GET'])]
    public function index(ExperienceRepository $experienceRepository): Response
    {
        return $this->render('experience/index.html.twig', [
            'formations' => $experienceRepository->findBy(
                ['type' => 'education'],
                ['dateDebut' => 'DESC', 'ordre' => 'ASC']
            ),
            'professionnels' => $experienceRepository->findBy(
                ['type' => 'professionnel'],
                ['dateDebut' => 'DESC', 'ordre' => 'ASC']
            ),
        ]);
    }

    #[Route('/experience/{id}', name: 'app_experience_show', methods: ['GET'])]
    public function show(Experience $experience): Response
    {
        return $this->render('experience/show.html.twig', [
            'experience' => $experience,
        ]);
    }
}
