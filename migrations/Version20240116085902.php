<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116085902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, INDEX IDX_B6BD307F5774FDDC (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, user_concerned_id INT NOT NULL, admin_concerned_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_97A0ADA360AD6A75 (user_concerned_id), INDEX IDX_97A0ADA39920B49A (admin_concerned_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F5774FDDC FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA360AD6A75 FOREIGN KEY (user_concerned_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA39920B49A FOREIGN KEY (admin_concerned_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F5774FDDC');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA360AD6A75');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA39920B49A');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('ALTER TABLE `user` CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin` COMMENT \'(DC2Type:json)\'');
    }
}
