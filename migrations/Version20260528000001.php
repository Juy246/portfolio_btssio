<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Add image_file column to certification table
 */
final class Version20260528000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add image_file column to certification table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE certification ADD image_file VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE certification DROP COLUMN image_file');
    }
}

