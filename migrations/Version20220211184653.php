<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211184653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ordre_du_jour (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion (id INT AUTO_INCREMENT NOT NULL, date VARCHAR(255) NOT NULL, objet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion_personnes (reunion_id INT NOT NULL, personnes_id INT NOT NULL, INDEX IDX_1C42E8A74E9B7368 (reunion_id), INDEX IDX_1C42E8A7146AD7BC (personnes_id), PRIMARY KEY(reunion_id, personnes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion_ordre_du_jour (reunion_id INT NOT NULL, ordre_du_jour_id INT NOT NULL, INDEX IDX_46BC5C2E4E9B7368 (reunion_id), INDEX IDX_46BC5C2EB0FA4786 (ordre_du_jour_id), PRIMARY KEY(reunion_id, ordre_du_jour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reunion_personnes ADD CONSTRAINT FK_1C42E8A74E9B7368 FOREIGN KEY (reunion_id) REFERENCES reunion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reunion_personnes ADD CONSTRAINT FK_1C42E8A7146AD7BC FOREIGN KEY (personnes_id) REFERENCES personnes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reunion_ordre_du_jour ADD CONSTRAINT FK_46BC5C2E4E9B7368 FOREIGN KEY (reunion_id) REFERENCES reunion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reunion_ordre_du_jour ADD CONSTRAINT FK_46BC5C2EB0FA4786 FOREIGN KEY (ordre_du_jour_id) REFERENCES ordre_du_jour (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reunion_ordre_du_jour DROP FOREIGN KEY FK_46BC5C2EB0FA4786');
        $this->addSql('ALTER TABLE reunion_personnes DROP FOREIGN KEY FK_1C42E8A74E9B7368');
        $this->addSql('ALTER TABLE reunion_ordre_du_jour DROP FOREIGN KEY FK_46BC5C2E4E9B7368');
        $this->addSql('DROP TABLE ordre_du_jour');
        $this->addSql('DROP TABLE reunion');
        $this->addSql('DROP TABLE reunion_personnes');
        $this->addSql('DROP TABLE reunion_ordre_du_jour');
        $this->addSql('ALTER TABLE evenement CHANGE date_event date_event VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE lieu CHANGE adresse_lieu adresse_lieu VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personnes CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE age age VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_entree date_entree VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE diplome diplome VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE exp_pro exp_pro VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tarifs CHANGE tranche_age tranche_age VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prix prix VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type CHANGE nom_type nom_type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
