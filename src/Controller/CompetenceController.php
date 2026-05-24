<?php

namespace App\Controller;

use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CompetenceController extends AbstractController
{
    #[Route('/competences', name: 'app_competence_index')]
    public function index(CompetenceRepository $competenceRepository): Response
    {
        $competences = $competenceRepository->findAll();

        // Grouper par catégorie
        $grouped = [];
        foreach ($competences as $comp) {
            $cat = $comp->getCategorie();
            if (!isset($grouped[$cat])) {
                $grouped[$cat] = [];
            }
            $grouped[$cat][] = $comp;
        }

        return $this->render('competence/index.html.twig', [
            'grouped_competences' => $grouped,
            'competences' => $competences,
        ]);
    }
}

