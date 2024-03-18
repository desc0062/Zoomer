<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111211533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A5EB747A3');
        $this->addSql('DROP INDEX IDX_AC74095A5EB747A3 ON activity');
        $this->addSql('ALTER TABLE activity CHANGE image_act image_act VARCHAR(255) DEFAULT NULL, CHANGE animal_id_id animal_id INT NOT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A8E962C16 ON activity (animal_id)');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE6146A8E4');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9D86650F');
        $this->addSql('DROP INDEX IDX_E00CEDDE9D86650F ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE6146A8E4 ON booking');
        $this->addSql('ALTER TABLE booking ADD user_id INT NOT NULL, ADD activity_id INT NOT NULL, DROP user_id_id, DROP activity_id_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEA76ED395 ON booking (user_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE81C06096 ON booking (activity_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE81C06096');
        $this->addSql('DROP INDEX IDX_E00CEDDEA76ED395 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE81C06096 ON booking');
        $this->addSql('ALTER TABLE booking ADD user_id_id INT NOT NULL, ADD activity_id_id INT NOT NULL, DROP user_id, DROP activity_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE6146A8E4 FOREIGN KEY (activity_id_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9D86650F ON booking (user_id_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE6146A8E4 ON booking (activity_id_id)');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A8E962C16');
        $this->addSql('DROP INDEX IDX_AC74095A8E962C16 ON activity');
        $this->addSql('ALTER TABLE activity CHANGE image_act image_act LONGBLOB DEFAULT NULL, CHANGE animal_id animal_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A5EB747A3 FOREIGN KEY (animal_id_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A5EB747A3 ON activity (animal_id_id)');
    }
}
