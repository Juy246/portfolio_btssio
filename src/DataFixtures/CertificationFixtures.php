<?php

namespace App\DataFixtures;

use App\Entity\Certification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CertificationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $certifications = [
            [
                'titre' => 'Certification PIX',
                'organisation' => 'PIX',
                'description' => 'Certification validant les compétences numériques essentielles',
                'certificat_file' => 'certification-pix.pdf',
                'badge' => null,
                'url' => 'https://app.pix.fr/verification-certificat',
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'dateObtention' => '2026',
            ],
            [
                'titre' => 'Gestion des cybermenaces',
                'organisation' => 'Cisco Networking Academy',
                'description' => 'Formation et certification couvrant les menaces cybernétiques et les stratégies de défense',
                'certificat_file' => 'Cyber_Threat_Management_certificate_jingyuan-luo.pdf',
                'badge' => 'https://www.credly.com/badges/bb2d706b-116e-4a85-bece-a811d8c303b0',
                'url' => 'https://www.credly.com/badges/bb2d706b-116e-4a85-bece-a811d8c303b0/linked_in_profile',
                'dateObtention' => '2025',
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            ],
            [
                'titre' => 'Introduction à la Cybersécurité',
                'organisation' => 'Cisco Networking Academy',
                'description' => 'Formation fondamentale en cybersécurité couvrant les principes de base et les bonnes pratiques',
                'certificat_file' => 'Introduction_to_Cybersecurity_certificate_jingyuan-luo.pdf',
                'badge' => 'https://www.credly.com/badges/224b2330-8d65-40bd-9ed5-d330c70adf02',
                'url' => 'https://www.credly.com/badges/224b2330-8d65-40bd-9ed5-d330c70adf02/linked_in_profile',
                'dateObtention' => '2025',
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            ],
        ];

        $repo = $manager->getRepository(Certification::class);

        foreach ($certifications as $data) {
            // Vérifier si la certification existe déjà (éviter les doublons)
            $existing = $repo->findOneBy(['titre' => $data['titre'], 'organisation' => $data['organisation']]);

            if ($existing) {
                // Mettre à jour les champs si la certification existe
                $existing->setDescription($data['description'] ?? null);
                $existing->setBadge($data['badge'] ?? null);
                $existing->setCertificatFile($data['certificat_file'] ?? null);
                $existing->setUrl($data['url'] ?? null);
                if (!empty($data['dateObtention'])) {
                    $existing->setDateObtention(new \DateTime($data['dateObtention']));
                }
                $manager->persist($existing);
            } else {
                // Créer une nouvelle certification
                $certification = new Certification();
                $certification->setTitre($data['titre']);
                $certification->setOrganisation($data['organisation']);
                $certification->setDescription($data['description'] ?? null);
                $certification->setBadge($data['badge'] ?? null);
                $certification->setCertificatFile($data['certificat_file'] ?? null);
                $certification->setUrl($data['url'] ?? null);

                if (!empty($data['dateObtention'])) {
                    $certification->setDateObtention(new \DateTime($data['dateObtention']));
                }

                $manager->persist($certification);
            }
        }

        $manager->flush();
    }
}


