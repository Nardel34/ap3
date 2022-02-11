<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211095154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement_personnes (evenement_id INT NOT NULL, personnes_id INT NOT NULL, INDEX IDX_85EAF2FAFD02F13 (evenement_id), INDEX IDX_85EAF2FA146AD7BC (personnes_id), PRIMARY KEY(evenement_id, personnes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement_personnes ADD CONSTRAINT FK_85EAF2FAFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_personnes ADD CONSTRAINT FK_85EAF2FA146AD7BC FOREIGN KEY (personnes_id) REFERENCES personnes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnes DROP FOREIGN KEY FK_2BB4FE2BFD02F13');
        $this->addSql('DROP INDEX IDX_2BB4FE2BFD02F13 ON personnes');
        $this->addSql('ALTER TABLE personnes DROP evenement_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE evenement_personnes');
        $this->addSql('ALTER TABLE evenement CHANGE date_event date_event VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE lieu CHANGE adresse_lieu adresse_lieu VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personnes ADD evenement_id INT DEFAULT NULL, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE age age VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_entree date_entree VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE diplome diplome VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE exp_pro exp_pro VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personnes ADD CONSTRAINT FK_2BB4FE2BFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_2BB4FE2BFD02F13 ON personnes (evenement_id)');
        $this->addSql('ALTER TABLE tarifs CHANGE tranche_age tranche_age VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prix prix VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type CHANGE nom_type nom_type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
