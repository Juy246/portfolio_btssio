<?php

namespace App\DataFixtures;

use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $projects = [

            [
                'titre' => 'GSB',
                'matiere' => 'Développement mobile',
                'categorie' => 'Application mobile',
                'description' => "Développement d’une API REST de gestion des rapports de visite pour le laboratoire GSB.
Cette solution s’accompagne d’une application mobile Android permettant aux visiteurs médicaux de centraliser, consulter et gérer leurs comptes-rendus de visite de manière sécurisée et intuitive.",
                'linkGithub' => 'https://github.com/Juy246/api_rest_gsb_visite',
                'linkDownload' => 'projets/GSB_Jingyuan_LUO.pdf',
            ],

            [
                'titre' => 'Conventio',
                'matiere' => 'Développement application web',
                'categorie' => 'Application web',
                'description' => "Conventio est une application web développée pour un lycée afin de centraliser la création, la validation et la signature des conventions de stage.
Le projet vise à digitaliser entièrement le processus administratif grâce à une gestion simplifiée des documents et l’intégration d’un système de signature électronique.",
                'linkGithub' => 'https://github.com/maxervj/Conventio',
                'linkDownload' => 'projets/Conventio_Technique_Jingyuan_LUO.pdf',
            ],

            [
                'titre' => 'Share Business',
                'matiere' => 'Développement application web',
                'categorie' => 'Application web',
                'description' => "Développement d’une application web sécurisée permettant le partage de documents sensibles (RIB, fichiers confidentiels) ainsi que de mots de passe.
L’objectif est de générer des liens temporaires vers des fichiers hébergés sur des serveurs exposés à l’extérieur afin de faciliter leur transmission sécurisée par email aux destinataires.",
                'linkGithub' => '',
                'linkDownload' => 'projets/DAT-ShareBusiness-Jingyuan_LUO.odt',
                'document_file' => 'projets/Document-utilisation_ShareBusiness_Jingyuan_LUO.pdf'
            ],

        ];

        foreach ($projects as $data) {

            $project = new Projet();

            $project->setTitre($data['titre']);
            $project->setMatiere($data['matiere']);
            $project->setCategorie($data['categorie']);
            $project->setDescription($data['description']);
            $project->setLinkGithub($data['linkGithub']);
            $project->setLinkDownload($data['linkDownload']);

            // Setter le document_file s'il existe
            if (isset($data['document_file'])) {
                $project->setDocumentFile($data['document_file']);
            }

            $manager->persist($project);
        }

        $manager->flush();
    }
}


