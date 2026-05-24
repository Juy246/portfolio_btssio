<?php

namespace App\DataFixtures;

use App\Entity\Experience;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExperienceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $experiences = [

            // =========================
            // EXPERIENCES PROFESSIONNELLES
            // =========================

            [
                'title' => 'Stagiaire Développeur',
                'company' => 'Botanic',
                'location' => 'Archamps, Haute-Savoie (France)',
                'startDate' => new \DateTime('2026-01-01'),
                'endDate' => new \DateTime('2026-03-31'),
                'type' => 'professional',
                'description' => [
                    'Développement d’une application web full-stack (front-end + back-end) de A à Z : cadrage, conception, réalisation et tests',
                    'Analyse du besoin client : recueil des attentes, clarification des fonctionnalités, documentation',
                    'Conception et mise en place de la base de données (modélisation, création des tables, requêtes, gestion des données)',
                    'Intégration et consommation d’API (appels, gestion des paramètres, traitement des réponses et gestion des erreurs)',
                    'Mise en œuvre de la sécurisation : authentification, gestion des accès, bonnes pratiques de sécurité',
                    'Génération de mot de passe paramétrable selon des règles définies',
                    'Ajout de journalisation / logging pour le suivi des événements et l’aide au diagnostic',
                ],
            ],

            [
                'title' => 'Stagiaire en informatique',
                'company' => 'Botanic',
                'location' => 'Archamps, Haute-Savoie (France)',
                'startDate' => new \DateTime('2025-06-01'),
                'endDate' => new \DateTime('2025-06-30'),
                'type' => 'professional',
                'description' => [
                    'Support technique aux magasins et collaborateurs',
                    'Paramétrage et dépannage de matériels',
                    'Observation des tâches de programmation et d’analyse',
                ],
            ],

            // =========================
            // EXPERIENCES SCOLAIRES
            // =========================

            [
                'title' => 'BTS Services Informatiques aux Organisations',
                'company' => 'Lycée Gabriel Fauré',
                'location' => 'Annecy, Haute-Savoie (France)',
                'startDate' => new \DateTime('2024-09-01'),
                'endDate' => new \DateTime('2026-06-30'),
                'type' => 'education',
                'description' => [
                    'Participation au dispositif IngéPLUS : accompagnement à la poursuite d’études (orientation, projet professionnel, renforcement académique)',
                    'Participation au forum de cybersécurité : animation d’une semaine d’interventions auprès de lycéens et collégiens pour sensibiliser aux cyberattaques, aux bonnes pratiques numériques et à la protection des données',
                ],
            ],

            [
                'title' => 'Licence LEA - Anglais Chinois',
                'company' => 'Université Grenoble Alpes',
                'location' => 'Grenoble, Isère (France)',
                'startDate' => new \DateTime('2019-09-01'),
                'endDate' => new \DateTime('2023-06-30'),
                'type' => 'education',
                'description' => [
                    'L2 avec mention Assez Bien',
                    'Parcours Anglais-Chinois',
                    'L3 spécialisation Coopération Internationale',
                ],
            ],

            [
                'title' => 'Baccalauréat STMG',
                'company' => 'Lycée Guillaume Fichet',
                'location' => 'Bonneville, Haute-Savoie (France)',
                'startDate' => new \DateTime('2016-09-01'),
                'endDate' => new \DateTime('2019-06-30'),
                'type' => 'education',
                'description' => [
                    'Mention Assez Bien',
                    'Option Gestion Finance',
                ],
            ],

            // =========================
            // EXPERIENCE ASSOCIATIVE
            // =========================

            [
                'title' => 'Bénévole',
                'company' => 'Festival international du film d\'animation d\'Annecy',
                'location' => 'Annecy, Haute-Savoie',
                'startDate' => new \DateTime('2021-06-01'),
                'endDate' => new \DateTime('2021-06-30'),
                'type' => 'associatif',
                'description' => [
                    'Participation à l’organisation et à l’accueil du public durant le festival',
                ],
            ],
        ];

        foreach ($experiences as $data) {
            $experience = new Experience();

            // format dates as 'Y-m' strings to match Experience entity storage
            $start = $data['startDate'] instanceof \DateTimeInterface ? $data['startDate']->format('Y-m') : (string) $data['startDate'];
            $end = $data['endDate'] instanceof \DateTimeInterface ? $data['endDate']->format('Y-m') : ($data['endDate'] ? (string) $data['endDate'] : null);

            // description array -> single string
            $desc = '';
            if (is_array($data['description'])) {
                $desc = implode("\n", $data['description']);
            } else {
                $desc = (string) $data['description'];
            }

            // map french types to expected values if necessary
            $type = $data['type'];
            if ($type === 'professionnel') { $type = 'professional'; }
            if ($type === 'scolaire') { $type = 'education'; }
            // keep 'associatif' as-is (will be treated like professional in templates)

            $experience->setTitle($data['title']);
            $experience->setCompany($data['company']);
            $experience->setLocation($data['location']);
            $experience->setStartDate($start);
            $experience->setEndDate($end);
            $experience->setType($type);
            $experience->setDescription($desc);

            $manager->persist($experience);
        }

        $manager->flush();
    }
}

