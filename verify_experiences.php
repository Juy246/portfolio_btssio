<?php
require __DIR__ . '/vendor/autoload.php';

use App\Kernel;
use App\Entity\Experience;

$dotenvPath = __DIR__ . '.env.local';
if (!file_exists($dotenvPath)) {
    $dotenvPath = __DIR__ . '.env';
}
if (file_exists($dotenvPath)) {
    (new \Symfony\Component\Dotenv\Dotenv())->load($dotenvPath);
}
$kernel = new Kernel($_ENV['APP_ENV'] ?? 'dev', (bool) ($_ENV['APP_DEBUG'] ?? false));
$kernel->boot();
$em = $kernel->getContainer()->get('doctrine')->getManager();
$repo = $em->getRepository(Experience::class);
$all = $repo->findAll();
echo "Total experiences: " . count($all) . "\n";
foreach ($all as $e) {
    echo "- " . $e->getTitle() . " (" . $e->getCompany() . ") [" . $e->getPeriod() . "] Type:" . $e->getType() . "\n";
}
$kernel->shutdown();

