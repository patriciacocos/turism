<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802173255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arta (id_arta INT AUTO_INCREMENT NOT NULL, nume VARCHAR(50) DEFAULT NULL, categorie VARCHAR(20) DEFAULT NULL, ora_deschidere TIME DEFAULT NULL, ora_inchidere TIME DEFAULT NULL, pret_bilet DOUBLE PRECISION DEFAULT NULL, adresa VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id_arta)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cazare (id_cazare INT AUTO_INCREMENT NOT NULL, nume VARCHAR(50) DEFAULT NULL, categorie VARCHAR(30) DEFAULT NULL, rating INT DEFAULT NULL, nr_camere INT DEFAULT NULL, pret_noapte DOUBLE PRECISION DEFAULT NULL, adresa VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id_cazare)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id_favorite INT AUTO_INCREMENT NOT NULL, id_arta INT DEFAULT NULL, id_cazare INT DEFAULT NULL, id_mancare_bautura INT DEFAULT NULL, id_monumente_istorice INT DEFAULT NULL, id_user INT DEFAULT NULL, nume VARCHAR(50) DEFAULT NULL, categorie VARCHAR(20) DEFAULT NULL, INDEX id_user (id_user), INDEX idArta (id_arta), INDEX idCazare (id_cazare), INDEX idMancareBautura (id_mancare_bautura), INDEX idMonumenteIstorice (id_monumente_istorice), PRIMARY KEY(id_favorite)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mancare_bautura (id_mancare_bautura INT AUTO_INCREMENT NOT NULL, nume VARCHAR(50) DEFAULT NULL, categorie VARCHAR(20) DEFAULT NULL, ora_deschidere TIME DEFAULT NULL, ora_inchidere TIME DEFAULT NULL, stil VARCHAR(20) DEFAULT NULL, rating INT DEFAULT NULL, adresa VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id_mancare_bautura)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monumente_istorice (id_monumente_istorice INT AUTO_INCREMENT NOT NULL, nume VARCHAR(50) NOT NULL, categorie VARCHAR(20) DEFAULT NULL, ora_deschidere TIME DEFAULT NULL, ora_inchidere TIME DEFAULT NULL, pret_bilet DOUBLE PRECISION DEFAULT NULL, an_constructie INT DEFAULT NULL, adresa VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id_monumente_istorice)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rezervare_cazare (id INT AUTO_INCREMENT NOT NULL, id_cazare INT DEFAULT NULL, id_user INT DEFAULT NULL, nume_hotel VARCHAR(50) DEFAULT NULL, nr_nopti INT DEFAULT NULL, INDEX id_cazare (id_cazare), INDEX user_id (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rezervare_obiective (id INT AUTO_INCREMENT NOT NULL, id_arta INT DEFAULT NULL, id_monument INT DEFAULT NULL, id_user INT DEFAULT NULL, nume_user VARCHAR(50) DEFAULT NULL, ora_rezervarii TIME DEFAULT NULL, nr_locuri INT DEFAULT NULL, INDEX id_arta (id_arta), INDEX id_monument (id_monument), INDEX user (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nume VARCHAR(20) DEFAULT NULL, prenume VARCHAR(20) DEFAULT NULL, parola VARCHAR(20) NOT NULL, email VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9F6D027A FOREIGN KEY (id_arta) REFERENCES arta (id_arta)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9D081580B FOREIGN KEY (id_cazare) REFERENCES cazare (id_cazare)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9BCCAF153 FOREIGN KEY (id_mancare_bautura) REFERENCES mancare_bautura (id_mancare_bautura)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED938ADA324 FOREIGN KEY (id_monumente_istorice) REFERENCES monumente_istorice (id_monumente_istorice)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED96B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rezervare_cazare ADD CONSTRAINT FK_DA345ED6D081580B FOREIGN KEY (id_cazare) REFERENCES cazare (id_cazare)');
        $this->addSql('ALTER TABLE rezervare_cazare ADD CONSTRAINT FK_DA345ED66B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rezervare_obiective ADD CONSTRAINT FK_604B1157F6D027A FOREIGN KEY (id_arta) REFERENCES arta (id_arta)');
        $this->addSql('ALTER TABLE rezervare_obiective ADD CONSTRAINT FK_604B11572B636E16 FOREIGN KEY (id_monument) REFERENCES monumente_istorice (id_monumente_istorice)');
        $this->addSql('ALTER TABLE rezervare_obiective ADD CONSTRAINT FK_604B11576B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9F6D027A');
        $this->addSql('ALTER TABLE rezervare_obiective DROP FOREIGN KEY FK_604B1157F6D027A');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9D081580B');
        $this->addSql('ALTER TABLE rezervare_cazare DROP FOREIGN KEY FK_DA345ED6D081580B');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9BCCAF153');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED938ADA324');
        $this->addSql('ALTER TABLE rezervare_obiective DROP FOREIGN KEY FK_604B11572B636E16');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED96B3CA4B');
        $this->addSql('ALTER TABLE rezervare_cazare DROP FOREIGN KEY FK_DA345ED66B3CA4B');
        $this->addSql('ALTER TABLE rezervare_obiective DROP FOREIGN KEY FK_604B11576B3CA4B');
        $this->addSql('DROP TABLE arta');
        $this->addSql('DROP TABLE cazare');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE mancare_bautura');
        $this->addSql('DROP TABLE monumente_istorice');
        $this->addSql('DROP TABLE rezervare_cazare');
        $this->addSql('DROP TABLE rezervare_obiective');
        $this->addSql('DROP TABLE user');
    }
}
