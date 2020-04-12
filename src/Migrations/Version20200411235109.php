<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200411235109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Commentaire (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, trajet_id INT DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, date_ajout DATE NOT NULL, INDEX IDX_E16CE76BB83297E7 (reservation_id), INDEX IDX_E16CE76BFB88E14F (utilisateur_id), INDEX IDX_E16CE76BD12A823 (trajet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Reservation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, trajet_id INT DEFAULT NULL, date_reserv DATE NOT NULL, nbre_place INT NOT NULL, INDEX IDX_C454C682FB88E14F (utilisateur_id), INDEX IDX_C454C682D12A823 (trajet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Trajet (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, ville_depart VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, heure_depart TIME NOT NULL, ville_arrive VARCHAR(255) NOT NULL, date_arrive DATE NOT NULL, heure_arrive TIME NOT NULL, nbre_place INT NOT NULL, nbre_place_dispo INT NOT NULL, prix DOUBLE PRECISION NOT NULL, distance INT NOT NULL, date_ajout DATE NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_2CF7ACBA989D9B62 (slug), INDEX IDX_2CF7ACBAFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Commentaire ADD CONSTRAINT FK_E16CE76BB83297E7 FOREIGN KEY (reservation_id) REFERENCES Reservation (id)');
        $this->addSql('ALTER TABLE Commentaire ADD CONSTRAINT FK_E16CE76BFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur (id)');
        $this->addSql('ALTER TABLE Commentaire ADD CONSTRAINT FK_E16CE76BD12A823 FOREIGN KEY (trajet_id) REFERENCES Trajet (id)');
        $this->addSql('ALTER TABLE Reservation ADD CONSTRAINT FK_C454C682FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur (id)');
        $this->addSql('ALTER TABLE Reservation ADD CONSTRAINT FK_C454C682D12A823 FOREIGN KEY (trajet_id) REFERENCES Trajet (id)');
        $this->addSql('ALTER TABLE Trajet ADD CONSTRAINT FK_2CF7ACBAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Commentaire DROP FOREIGN KEY FK_E16CE76BB83297E7');
        $this->addSql('ALTER TABLE Commentaire DROP FOREIGN KEY FK_E16CE76BD12A823');
        $this->addSql('ALTER TABLE Reservation DROP FOREIGN KEY FK_C454C682D12A823');
        $this->addSql('ALTER TABLE Commentaire DROP FOREIGN KEY FK_E16CE76BFB88E14F');
        $this->addSql('ALTER TABLE Reservation DROP FOREIGN KEY FK_C454C682FB88E14F');
        $this->addSql('ALTER TABLE Trajet DROP FOREIGN KEY FK_2CF7ACBAFB88E14F');
        $this->addSql('DROP TABLE Commentaire');
        $this->addSql('DROP TABLE Reservation');
        $this->addSql('DROP TABLE Trajet');
        $this->addSql('DROP TABLE Utilisateur');
    }
}
