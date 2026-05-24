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

/** @var \Doctrine\DBAL\Connection $connection */
$connection = $kernel->getContainer()->get('doctrine.dbal.default_connection');

try {
    // Check if logo column exists
    $sm = $connection->createSchemaManager();
    $columns = $sm->listTableColumns('competence');

    if (!isset($columns['logo'])) {
        echo "[INFO] Adding 'logo' column to competence table...\n";
        $connection->executeStatement('ALTER TABLE competence ADD COLUMN logo VARCHAR(255) DEFAULT NULL');
        echo "[OK] Column 'logo' added successfully\n";
    } else {
        echo "[INFO] Column 'logo' already exists\n";
    }
} catch (Exception $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
}

$kernel->shutdown();

