<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Create base tables for all entities
 */
final class Version20260524000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create base tables for all entities';
    }

    public function up(Schema $schema): void
    {
        // Create competence table
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(500) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create contact table
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, sujet VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create experience table
        $this->addSql('CREATE TABLE `experience` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(100) NOT NULL, company VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, start_date VARCHAR(20) NOT NULL, end_date VARCHAR(20) DEFAULT NULL, display_order INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create experience_competence join table
        $this->addSql('CREATE TABLE experience_competence (experience_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_17887BFE47A46B0A (experience_id), INDEX IDX_17887BFE15761DAB (competence_id), PRIMARY KEY(experience_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create projet table
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, matiere VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, link_github VARCHAR(255) NOT NULL, link_download VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create veille table
        $this->addSql('CREATE TABLE veille (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, url VARCHAR(500) DEFAULT NULL, pdf_file VARCHAR(255) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Add foreign key constraints for experience_competence
        $this->addSql('ALTER TABLE experience_competence ADD CONSTRAINT FK_17887BFE47A46B0A FOREIGN KEY (experience_id) REFERENCES `experience` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience_competence ADD CONSTRAINT FK_17887BFE15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience_competence DROP FOREIGN KEY FK_17887BFE15761DAB');
        $this->addSql('ALTER TABLE experience_competence DROP FOREIGN KEY FK_17887BFE47A46B0A');
        $this->addSql('DROP TABLE experience_competence');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE `experience`');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE veille');
    }
}

