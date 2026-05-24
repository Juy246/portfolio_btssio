<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\CompetenceRepository;
use App\Repository\ContactRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ProjetRepository;
use App\Repository\VeilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        ExperienceRepository $experienceRepository,
        CompetenceRepository $competenceRepository,
        ProjetRepository $projetRepository,
        VeilleRepository $veilleRepository,
        ContactRepository $contactRepository,
        EntityManagerInterface $em,
    ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setCreatedAt(new \DateTime());
            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'experiences' => $experienceRepository->findAll(),
            'competences' => $competenceRepository->findAll(),
            'projets' => $projetRepository->findAll(),
            'veilles' => $veilleRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }
}
