<?php

require 'vendor/autoload.php';

use App\Kernel;
use App\Entity\Certification;
use Symfony\Component\Dotenv\Dotenv;

$pixUrl = 'https://app.pix.fr/verification-certificat';
$ctmUrl = 'https://www.credly.com/badges/bb2d706b-116e-4a85-bece-a811d8c303b0/linked_in_profile';
$introUrl = 'https://www.credly.com/badges/224b2330-8d65-40bd-9ed5-d330c70adf02/linked_in_profile';

// Load environment variables
$dotenv = new Dotenv();
if (file_exists('.env.local')) {
    $dotenv->load('.env.local');
} else {
    $dotenv->load('.env');
}

$kernel = new Kernel($_ENV['APP_ENV'] ?? 'dev', (bool) ($_ENV['APP_DEBUG'] ?? false));
$kernel->boot();

$entityManager = $kernel->getContainer()->get('doctrine')->getManager();
$repo = $entityManager->getRepository(Certification::class);

$all = $repo->findAll();
if (count($all) === 0) {
    echo "[INFO] No certifications found in database.\n";
    $kernel->shutdown();
    exit;
}

$certDir = __DIR__ . '/public/certifications';
$files = [];
if (is_dir($certDir)) {
    foreach (scandir($certDir) as $f) {
        if (in_array($f, ['.', '..'])) continue;
        $files[] = $f;
    }
}

$updated = 0;

foreach ($all as $cert) {
    /** @var Certification $cert */
    $titre = strtolower($cert->getTitre() ?? '');
    $org = strtolower($cert->getOrganisation() ?? '');

    $changed = false;

    if (str_contains($titre, 'pix') || str_contains($org, 'pix')) {
        if ($cert->getUrl() !== $pixUrl) {
            $cert->setUrl($pixUrl);
            $changed = true;
        }
        // try to find a pdf with pix in name
        foreach ($files as $f) {
            if (stripos($f, 'pix') !== false) {
                if ($cert->getCertificatFile() !== $f) {
                    $cert->setCertificatFile($f);
                    $changed = true;
                }
                break;
            }
        }
    }

    if (str_contains($titre, 'cyber') || str_contains($titre, 'cybermenace') || str_contains($titre, 'cyber threat') || str_contains($org, 'credly') || str_contains($titre, 'gestion des cybermenaces') ) {
        if ($cert->getUrl() !== $ctmUrl) {
            $cert->setUrl($ctmUrl);
            $changed = true;
        }
        foreach ($files as $f) {
            if (stripos($f, 'cyber') !== false || stripos($f, 'threat') !== false) {
                if ($cert->getCertificatFile() !== $f) {
                    $cert->setCertificatFile($f);
                    $changed = true;
                }
                break;
            }
        }
    }

    if (str_contains($titre, 'introduction') || str_contains($titre, 'introduction à la cybersécurité') || str_contains($titre, 'introduction a la cybersécurité') || str_contains($titre, 'introduction cybers') ) {
        if ($cert->getUrl() !== $introUrl) {
            $cert->setUrl($introUrl);
            $changed = true;
        }
        foreach ($files as $f) {
            if (stripos($f, 'introduction') !== false || stripos($f, 'introd') !== false) {
                if ($cert->getCertificatFile() !== $f) {
                    $cert->setCertificatFile($f);
                    $changed = true;
                }
                break;
            }
        }
    }

    if ($changed) {
        $entityManager->persist($cert);
        $updated++;
        echo "[INFO] Updated certification: " . $cert->getTitre() . "\n";
    }
}

if ($updated > 0) {
    $entityManager->flush();
    echo "[OK] Updated {$updated} certifications.\n";
} else {
    echo "[INFO] No certifications needed updating.\n";
}

$kernel->shutdown();


