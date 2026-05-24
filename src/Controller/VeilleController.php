<?php

namespace App\Controller;

use App\Repository\VeilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VeilleController extends AbstractController
{
    #[Route('/documents', name: 'app_veille_index')]
    public function index(VeilleRepository $veilleRepository): Response
    {
        $veilles = $veilleRepository->findBy([], ['date' => 'DESC']);

        return $this->render('veille/index.html.twig', [
            'veilles' => $veilles,
        ]);
    }
}

