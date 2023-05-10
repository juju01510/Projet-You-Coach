<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510093833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE training_presence (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, training_id INT DEFAULT NULL, is_present TINYINT(1) DEFAULT NULL, INDEX IDX_8E12D43299E6F5DF (player_id), INDEX IDX_8E12D432BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training_presence ADD CONSTRAINT FK_8E12D43299E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE training_presence ADD CONSTRAINT FK_8E12D432BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE training_presence DROP FOREIGN KEY FK_8E12D43299E6F5DF');
        $this->addSql('ALTER TABLE training_presence DROP FOREIGN KEY FK_8E12D432BEFD98D1');
        $this->addSql('DROP TABLE training_presence');
    }
}
