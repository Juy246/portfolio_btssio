<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em): Response
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

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/send', name: 'app_contact_send', methods: ['POST'])]
    public function send(Request $request, EntityManagerInterface $em, MailerInterface $mailer, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        try {
            // Valider le token CSRF
            $token = $request->request->get('_token');
            if (!$csrfTokenManager->isTokenValid(new CsrfToken('contact_form', $token))) {
                return $this->json([
                    'success' => false,
                    'message' => 'Token de sécurité invalide.',
                ], Response::HTTP_FORBIDDEN);
            }

            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $email = $request->request->get('email');
            $sujet = $request->request->get('sujet');
            $message = $request->request->get('message');

            // Valider les données
            if (!$nom || !$prenom || !$email || !$sujet || !$message) {
                return $this->json([
                    'success' => false,
                    'message' => 'Veuillez remplir tous les champs.',
                ], Response::HTTP_BAD_REQUEST);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->json([
                    'success' => false,
                    'message' => 'L\'adresse email n\'est pas valide.',
                ], Response::HTTP_BAD_REQUEST);
            }

            // Créer et sauvegarder le contact
            $contact = new Contact();
            $contact->setNom($nom);
            $contact->setPrenom($prenom);
            $contact->setEmail($email);
            $contact->setSujet($sujet);
            $contact->setMessage($message);
            $contact->setCreatedAt(new \DateTime());

            $em->persist($contact);
            $em->flush();

            // Envoyer l'email seulement à l'admin
            try {
                $emailToAdmin = (new Email())
                    ->from('noreply@portfolio.fr')
                    ->to('annieluo@outlook.fr')
                    ->subject('Nouveau message de contact par Portfolio - ' . $sujet)
                    ->html($this->renderView('email/contact_admin.html.twig', [
                        'contact' => $contact,
                    ]));

                $mailer->send($emailToAdmin);
            } catch (\Exception $mailError) {
                // Si l'email échoue, on le note mais on renvoie quand même succès
                // car les données ont été sauvegardées en base de données
            }

            return $this->json([
                'success' => true,
                'message' => 'Votre message a bien été envoyé ! ',
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Une erreur s\'est produite. Veuillez réessayer plus tard.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}



