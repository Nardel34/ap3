<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220217142654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, lieu_id INT NOT NULL, personnes_id INT DEFAULT NULL, date_event DATETIME NOT NULL, INDEX IDX_B26681EC54C8C93 (type_id), INDEX IDX_B26681E6AB213CC (lieu_id), INDEX IDX_B26681E146AD7BC (personnes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_personnes (evenement_id INT NOT NULL, personnes_id INT NOT NULL, INDEX IDX_85EAF2FAFD02F13 (evenement_id), INDEX IDX_85EAF2FA146AD7BC (personnes_id), PRIMARY KEY(evenement_id, personnes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, adresse_lieu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordre_du_jour (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnes (id INT AUTO_INCREMENT NOT NULL, tarifs_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, date_entree VARCHAR(255) DEFAULT NULL, diplome VARCHAR(255) DEFAULT NULL, exp_pro VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2BB4FE2BE7927C74 (email), INDEX IDX_2BB4FE2BF5F3287F (tarifs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion (id INT AUTO_INCREMENT NOT NULL, objet VARCHAR(255) NOT NULL, date_reunion DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion_personnes (reunion_id INT NOT NULL, personnes_id INT NOT NULL, INDEX IDX_1C42E8A74E9B7368 (reunion_id), INDEX IDX_1C42E8A7146AD7BC (personnes_id), PRIMARY KEY(reunion_id, personnes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion_ordre_du_jour (reunion_id INT NOT NULL, ordre_du_jour_id INT NOT NULL, INDEX IDX_46BC5C2E4E9B7368 (reunion_id), INDEX IDX_46BC5C2EB0FA4786 (ordre_du_jour_id), PRIMARY KEY(reunion_id, ordre_du_jour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarifs (id INT AUTO_INCREMENT NOT NULL, tranche_age VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom_type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E6AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E146AD7BC FOREIGN KEY (personnes_id) REFERENCES personnes (id)');
        $this->addSql('ALTER TABLE evenement_personnes ADD CONSTRAINT FK_85EAF2FAFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_personnes ADD CONSTRAINT FK_85EAF2FA146AD7BC FOREIGN KEY (personnes_id) REFERENCES personnes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnes ADD CONSTRAINT FK_2BB4FE2BF5F3287F FOREIGN KEY (tarifs_id) REFERENCES tarifs (id)');
        $this->addSql('ALTER TABLE reunion_personnes ADD CONSTRAINT FK_1C42E8A74E9B7368 FOREIGN KEY (reunion_id) REFERENCES reunion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reunion_personnes ADD CONSTRAINT FK_1C42E8A7146AD7BC FOREIGN KEY (personnes_id) REFERENCES personnes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reunion_ordre_du_jour ADD CONSTRAINT FK_46BC5C2E4E9B7368 FOREIGN KEY (reunion_id) REFERENCES reunion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reunion_ordre_du_jour ADD CONSTRAINT FK_46BC5C2EB0FA4786 FOREIGN KEY (ordre_du_jour_id) REFERENCES ordre_du_jour (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement_personnes DROP FOREIGN KEY FK_85EAF2FAFD02F13');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E6AB213CC');
        $this->addSql('ALTER TABLE reunion_ordre_du_jour DROP FOREIGN KEY FK_46BC5C2EB0FA4786');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E146AD7BC');
        $this->addSql('ALTER TABLE evenement_personnes DROP FOREIGN KEY FK_85EAF2FA146AD7BC');
        $this->addSql('ALTER TABLE reunion_personnes DROP FOREIGN KEY FK_1C42E8A7146AD7BC');
        $this->addSql('ALTER TABLE reunion_personnes DROP FOREIGN KEY FK_1C42E8A74E9B7368');
        $this->addSql('ALTER TABLE reunion_ordre_du_jour DROP FOREIGN KEY FK_46BC5C2E4E9B7368');
        $this->addSql('ALTER TABLE personnes DROP FOREIGN KEY FK_2BB4FE2BF5F3287F');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC54C8C93');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE evenement_personnes');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE ordre_du_jour');
        $this->addSql('DROP TABLE personnes');
        $this->addSql('DROP TABLE reunion');
        $this->addSql('DROP TABLE reunion_personnes');
        $this->addSql('DROP TABLE reunion_ordre_du_jour');
        $this->addSql('DROP TABLE tarifs');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
