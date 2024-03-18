<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109094740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, animal_id_id INT NOT NULL, name VARCHAR(50) NOT NULL, date DATETIME NOT NULL, description VARCHAR(1024) DEFAULT NULL, nb_of_places INT NOT NULL, image_act LONGBLOB DEFAULT NULL, INDEX IDX_AC74095A5EB747A3 (animal_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(1024) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, activity_id_id INT NOT NULL, INDEX IDX_E00CEDDE9D86650F (user_id_id), INDEX IDX_E00CEDDE6146A8E4 (activity_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A5EB747A3 FOREIGN KEY (animal_id_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE6146A8E4 FOREIGN KEY (activity_id_id) REFERENCES activity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A5EB747A3');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9D86650F');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE6146A8E4');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
