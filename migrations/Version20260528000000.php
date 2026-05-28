<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Add document_file column to projet table
 */
final class Version20260528000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add document_file column to projet table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE projet ADD document_file VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE projet DROP COLUMN document_file');
    }
}

