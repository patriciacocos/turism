<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220902183311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rezervare_cazare DROP data_sosire, DROP data_plecare, CHANGE nume_user nume_hotel VARCHAR(50) DEFAULT NULL, CHANGE nr_camere nr_nopti INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rezervare_cazare ADD data_sosire DATE DEFAULT NULL, ADD data_plecare DATE DEFAULT NULL, CHANGE nume_hotel nume_user VARCHAR(50) DEFAULT NULL, CHANGE nr_nopti nr_camere INT DEFAULT NULL');
    }
}
