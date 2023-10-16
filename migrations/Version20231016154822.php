<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016154822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, code_postal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campus DROP id_campus');
        $this->addSql('ALTER TABLE etat ADD nom VARCHAR(255) NOT NULL, ADD date_heure_debut DATE NOT NULL, ADD date_limite_inscription DATE NOT NULL, ADD nb_inscriptions_max INT NOT NULL, ADD infos_sortie VARCHAR(2500) DEFAULT NULL, ADD etat VARCHAR(30) NOT NULL, CHANGE id_etat duree INT NOT NULL');
        $this->addSql('ALTER TABLE participant ADD campus_id INT NOT NULL, CHANGE idparticipant sortie_id INT NOT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_D79F6B11CC72D953 ON participant (sortie_id)');
        $this->addSql('CREATE INDEX IDX_D79F6B11AF5D55E1 ON participant (campus_id)');
        $this->addSql('ALTER TABLE sortie ADD campus_id INT DEFAULT NULL, ADD etat_id INT NOT NULL, CHANGE id_sortie lieu_id INT NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F26AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2AF5D55E1 ON sortie (campus_id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F26AB213CC ON sortie (lieu_id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2D5E86FF ON sortie (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F26AB213CC');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE ville');
        $this->addSql('ALTER TABLE campus ADD id_campus INT NOT NULL');
        $this->addSql('ALTER TABLE etat ADD id_etat INT NOT NULL, DROP nom, DROP date_heure_debut, DROP duree, DROP date_limite_inscription, DROP nb_inscriptions_max, DROP infos_sortie, DROP etat');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11CC72D953');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11AF5D55E1');
        $this->addSql('DROP INDEX IDX_D79F6B11CC72D953 ON participant');
        $this->addSql('DROP INDEX IDX_D79F6B11AF5D55E1 ON participant');
        $this->addSql('ALTER TABLE participant ADD idparticipant INT NOT NULL, DROP sortie_id, DROP campus_id');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2AF5D55E1');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2D5E86FF');
        $this->addSql('DROP INDEX IDX_3C3FD3F2AF5D55E1 ON sortie');
        $this->addSql('DROP INDEX IDX_3C3FD3F26AB213CC ON sortie');
        $this->addSql('DROP INDEX IDX_3C3FD3F2D5E86FF ON sortie');
        $this->addSql('ALTER TABLE sortie ADD id_sortie INT NOT NULL, DROP campus_id, DROP lieu_id, DROP etat_id');
    }
}
