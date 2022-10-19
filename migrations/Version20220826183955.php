<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826183955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE monument_istoric_image (id INT AUTO_INCREMENT NOT NULL, monumente_istorice_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D12C1481A5FF8C4B (monumente_istorice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE monument_istoric_image ADD CONSTRAINT FK_D12C1481A5FF8C4B FOREIGN KEY (monumente_istorice_id) REFERENCES monumente_istorice (id_monumente_istorice)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE monument_istoric_image');
    }
}
