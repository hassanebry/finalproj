<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200327121859 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Trajet (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, ville_depart VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, heure_depart TIME NOT NULL, ville_arrive VARCHAR(255) NOT NULL, date_arrive DATE NOT NULL, heure_arrive TIME NOT NULL, nbre_place INT NOT NULL, nbre_place_dispo INT NOT NULL, prix DOUBLE PRECISION NOT NULL, distance INT NOT NULL, date_ajout DATE NOT NULL, INDEX IDX_2CF7ACBAFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Trajet ADD CONSTRAINT FK_2CF7ACBAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Trajet DROP FOREIGN KEY FK_2CF7ACBAFB88E14F');
        $this->addSql('DROP TABLE Trajet');
        $this->addSql('DROP TABLE Utilisateur');
    }
}
