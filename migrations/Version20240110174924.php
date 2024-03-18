<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110174924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD poids INT NOT NULL, ADD taille INT NOT NULL, ADD habitat VARCHAR(170) NOT NULL, ADD esperance_vie INT NOT NULL, ADD espece VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP poids, DROP taille, DROP habitat, DROP esperance_vie, DROP espece');
        $this->addSql('ALTER TABLE `user` CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
