<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409021009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_commentaire_utilisateur');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_commentaire_evenement');
        $this->addSql('ALTER TABLE commentaire CHANGE idE idE INT DEFAULT NULL, CHANGE idU idU INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCBF603201 FOREIGN KEY (idE) REFERENCES evenement (idE)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA2D72265 FOREIGN KEY (idU) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY fk_evenement');
        $this->addSql('ALTER TABLE evenement CHANGE IdP IdP INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EEAF0900A FOREIGN KEY (IdP) REFERENCES page (IdP)');
        $this->addSql('ALTER TABLE preferences CHANGE idu idu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponser CHANGE idR idR INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD img VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCBF603201');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA2D72265');
        $this->addSql('ALTER TABLE commentaire CHANGE idE idE INT NOT NULL, CHANGE idU idU INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_commentaire_utilisateur FOREIGN KEY (idU) REFERENCES utilisateur (idu) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_commentaire_evenement FOREIGN KEY (idE) REFERENCES evenement (idE) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EEAF0900A');
        $this->addSql('ALTER TABLE evenement CHANGE IdP IdP INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT fk_evenement FOREIGN KEY (IdP) REFERENCES page (IdP) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE preferences CHANGE idu idu INT NOT NULL');
        $this->addSql('ALTER TABLE reponser CHANGE idR idR INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP img');
    }
}
