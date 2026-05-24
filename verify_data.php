<?php

require 'vendor/autoload.php';

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

// Load environment variables
$dotenv = new Dotenv();
if (file_exists('.env.local')) {
    $dotenv->load('.env.local');
} else {
    $dotenv->load('.env');
}

// Create kernel
$kernel = new Kernel($_ENV['APP_ENV'] ?? 'dev', (bool) ($_ENV['APP_DEBUG'] ?? false));
$kernel->boot();

$connection = $kernel->getContainer()->get('doctrine.dbal.default_connection');

try {
    // Check competences in database
    $result = $connection->executeQuery('SELECT COUNT(*) as total, COUNT(DISTINCT categorie) as categories FROM competence')->fetchAssociative();

    echo "[INFO] Database Statistics:\n";
    echo "  - Total competences: " . $result['total'] . "\n";
    echo "  - Categories: " . $result['categories'] . "\n";

    // List categories
    $categories = $connection->executeQuery('SELECT DISTINCT categorie FROM competence ORDER BY categorie')->fetchAllAssociative();
    echo "\n[INFO] Categories loaded:\n";
    foreach ($categories as $cat) {
        $count = $connection->executeQuery('SELECT COUNT(*) as cnt FROM competence WHERE categorie = ?', [$cat['categorie']])->fetchAssociative();
        echo "  - " . $cat['categorie'] . " (" . $count['cnt'] . " items)\n";
    }

} catch (Exception $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
}

$kernel->shutdown();

