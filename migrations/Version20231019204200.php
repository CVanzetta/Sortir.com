<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019204200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('DROP INDEX UNIQ_D79F6B115126AC48 ON participant');
        $this->addSql('ALTER TABLE participant CHANGE mail email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D79F6B11E7927C74 ON participant (email)');
        //$this->addSql('ALTER TABLE sortie ADD organisateur_id INT NOT NULL, DROP etat, CHANGE campus_id campus_id INT NOT NULL, CHANGE date_heure_debut date_heure_debut DATETIME NOT NULL, CHANGE infos_sortie infos_sortie LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2D936B2FA FOREIGN KEY (organisateur_id) REFERENCES participant (id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2D936B2FA ON sortie (organisateur_id)');
        $this->addSql('ALTER TABLE ville CHANGE code_postal code_postal VARCHAR(6) NOT NULL');
    }
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville CHANGE code_postal code_postal INT NOT NULL');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2D936B2FA');
        $this->addSql('DROP INDEX IDX_3C3FD3F2D936B2FA ON sortie');
        //$this->addSql('ALTER TABLE sortie ADD etat VARCHAR(30) NOT NULL, DROP organisateur_id, CHANGE campus_id campus_id INT DEFAULT NULL, CHANGE date_heure_debut date_heure_debut DATE NOT NULL, CHANGE infos_sortie infos_sortie VARCHAR(2500) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_D79F6B11E7927C74 ON participant');
        $this->addSql('ALTER TABLE participant CHANGE email mail VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D79F6B115126AC48 ON participant (mail)');
    }
}
