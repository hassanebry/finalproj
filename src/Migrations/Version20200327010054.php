<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200327010054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE avis CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE trajet_id trajet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE trajet_id trajet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation RENAME INDEX idx_42c84955fb88e14f TO IDX_C454C682FB88E14F');
        $this->addSql('ALTER TABLE reservation RENAME INDEX idx_42c84955d12a823 TO IDX_C454C682D12A823');
        $this->addSql('ALTER TABLE trajet CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet RENAME INDEX idx_2b5ba98cfb88e14f TO IDX_2CF7ACBAFB88E14F');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE avis CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE trajet_id trajet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Reservation CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL, CHANGE trajet_id trajet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Reservation RENAME INDEX idx_c454c682d12a823 TO IDX_42C84955D12A823');
        $this->addSql('ALTER TABLE Reservation RENAME INDEX idx_c454c682fb88e14f TO IDX_42C84955FB88E14F');
        $this->addSql('ALTER TABLE Trajet CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Trajet RENAME INDEX idx_2cf7acbafb88e14f TO IDX_2B5BA98CFB88E14F');
    }
}
