<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompetenceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $competences = [
            // Environnements de développement
            ['categorie' => 'Environnements de développement', 'nom' => 'GitHub', 'url' => 'https://github.com'],
            ['categorie' => 'Environnements de développement', 'nom' => 'GitLab', 'url' => 'https://gitlab.com'],
            ['categorie' => 'Environnements de développement', 'nom' => 'Visual Studio Code', 'url' => 'https://code.visualstudio.com'],
            ['categorie' => 'Environnements de développement', 'nom' => 'Visual Studio 2022', 'url' => 'https://visualstudio.microsoft.com'],
            ['categorie' => 'Environnements de développement', 'nom' => 'Android Studio', 'url' => 'https://developer.android.com/studio'],
            ['categorie' => 'Environnements de développement', 'nom' => 'PhpStorm', 'url' => 'https://www.jetbrains.com/phpstorm'],

            // Gestion de bases de données et requêtes
            ['categorie' => 'Gestion de bases de données et requêtes', 'nom' => 'MySQL', 'url' => 'https://www.mysql.com'],
            ['categorie' => 'Gestion de bases de données et requêtes', 'nom' => 'SQL', 'url' => 'https://www.w3schools.com/sql'],
            ['categorie' => 'Gestion de bases de données et requêtes', 'nom' => 'MariaDB', 'url' => 'https://mariadb.org'],
            ['categorie' => 'Gestion de bases de données et requêtes', 'nom' => 'MongoDB', 'url' => 'https://www.mongodb.com'],
            ['categorie' => 'Gestion de bases de données et requêtes', 'nom' => 'Microsoft SQL Server', 'url' => 'https://www.microsoft.com/sql-server'],

            // Développement web
            ['categorie' => 'Développement web', 'nom' => 'HTML', 'url' => 'https://www.w3schools.com/html'],
            ['categorie' => 'Développement web', 'nom' => 'CSS', 'url' => 'https://www.w3schools.com/css'],
            ['categorie' => 'Développement web', 'nom' => 'PHP', 'url' => 'https://www.php.net'],
            ['categorie' => 'Développement web', 'nom' => 'JavaScript', 'url' => 'https://www.javascript.com'],
            ['categorie' => 'Développement web', 'nom' => 'TypeScript', 'url' => 'https://www.typescriptlang.org'],
            ['categorie' => 'Développement web', 'nom' => 'Bootstrap 5', 'url' => 'https://getbootstrap.com'],
            ['categorie' => 'Développement web', 'nom' => 'Symfony', 'url' => 'https://symfony.com'],
            ['categorie' => 'Développement web', 'nom' => 'WordPress', 'url' => 'https://wordpress.org'],
            ['categorie' => 'Développement web', 'nom' => 'ExpressJS', 'url' => 'https://expressjs.com'],
            ['categorie' => 'Développement web', 'nom' => 'React', 'url' => 'https://react.dev'],

            // Développement d'application
            ['categorie' => 'Développement d\'application', 'nom' => 'C# (WPF/Console)', 'url' => 'https://learn.microsoft.com/dotnet/csharp'],
            ['categorie' => 'Développement d\'application', 'nom' => 'Python', 'url' => 'https://www.python.org'],
            ['categorie' => 'Développement d\'application', 'nom' => 'PHP', 'url' => 'https://www.php.net'],
            ['categorie' => 'Développement d\'application', 'nom' => 'Java', 'url' => 'https://www.java.com'],

            // Cybersécurité
            ['categorie' => 'Cybersécurité', 'nom' => 'RGPD', 'url' => 'https://www.cnil.fr/rgpd'],
            ['categorie' => 'Cybersécurité', 'nom' => 'Cisco', 'url' => 'https://www.cisco.com'],
            ['categorie' => 'Cybersécurité', 'nom' => 'OWASP', 'url' => 'https://owasp.org'],
            ['categorie' => 'Cybersécurité', 'nom' => 'Chiffrement', 'url' => 'https://www.cryptography.com'],

            // Systèmes d'exploitation
            ['categorie' => 'Systèmes d\'exploitation', 'nom' => 'Windows 11', 'url' => 'https://www.microsoft.com/windows'],
            ['categorie' => 'Systèmes d\'exploitation', 'nom' => 'Windows Server', 'url' => 'https://www.microsoft.com/windows-server'],
            ['categorie' => 'Systèmes d\'exploitation', 'nom' => 'Linux Debian', 'url' => 'https://www.debian.org'],
            ['categorie' => 'Systèmes d\'exploitation', 'nom' => 'Linux Kali', 'url' => 'https://www.kali.org'],

            // Virtualisation
            ['categorie' => 'Virtualisation', 'nom' => 'VMWare', 'url' => 'https://www.vmware.com'],
            ['categorie' => 'Virtualisation', 'nom' => 'VirtualBox', 'url' => 'https://www.virtualbox.org'],

            // Cloud
            ['categorie' => 'Cloud', 'nom' => 'AWS', 'url' => 'https://aws.amazon.com'],
            ['categorie' => 'Cloud', 'nom' => 'Microsoft Azure', 'url' => 'https://azure.microsoft.com'],

            // Bureautique
            ['categorie' => 'Bureautique', 'nom' => 'Google Workspace', 'url' => 'https://workspace.google.com'],
            ['categorie' => 'Bureautique', 'nom' => 'Microsoft Office', 'url' => 'https://www.microsoft.com/office'],
        ];

        // Helper to generate a slug filename for logo from the competence name
        $slugify = function (string $name) {
            $trans = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
            $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $trans);
            $slug = trim($slug, '-');
            $slug = strtolower($slug);
            return $slug . '.png';
        };

        $repo = $manager->getRepository(Competence::class);

        foreach ($competences as $data) {
            // compute a default logo filename (you can replace with actual filenames you place in public/images/competences)
            $data['logo'] = $slugify($data['nom']);

            // Try to find existing competence (avoid duplicates)
            $existing = $repo->findOneBy(['nom' => $data['nom'], 'categorie' => $data['categorie']]);

            if ($existing) {
                // update URL and logo if present
                $existing->setUrl($data['url'] ?? null);
                $existing->setLogo($data['logo'] ?? null);
                $manager->persist($existing);
            } else {
                $competence = new Competence();
                $competence->setNom($data['nom']);
                $competence->setCategorie($data['categorie']);
                $competence->setDescription('');
                $competence->setUrl($data['url'] ?? null);
                $competence->setLogo($data['logo'] ?? null);
                $manager->persist($competence);
            }
        }

        $manager->flush();
    }
}
