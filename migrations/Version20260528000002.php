<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Add image_projet column to projet table
 */
final class Version20260528000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add image_projet column to projet table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE projet ADD image_projet VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE projet DROP COLUMN image_projet');
    }
}

