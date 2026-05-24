<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    #[Route('/projets', name: 'app_projet_index')]
    public function index(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();

        // Grouper par catégorie
        $grouped = [];
        foreach ($projets as $p) {
            $cat = $p->getCategorie() ?? 'Autres';
            if (!isset($grouped[$cat])) {
                $grouped[$cat] = [];
            }
            $grouped[$cat][] = $p;
        }

        return $this->render('projet/index.html.twig', [
            'grouped_projets' => $grouped,
            'projets' => $projets,
        ]);
    }
}

