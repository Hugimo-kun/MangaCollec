<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617114747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manga_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, manga_id INT NOT NULL, volume_number INT NOT NULL, collected TINYINT(1) NOT NULL, readed TINYINT(1) NOT NULL, INDEX IDX_D2C73F03A76ED395 (user_id), INDEX IDX_D2C73F037B6461 (manga_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manga_user ADD CONSTRAINT FK_D2C73F03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE manga_user ADD CONSTRAINT FK_D2C73F037B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
        $this->addSql('ALTER TABLE manga DROP collected, DROP readed, DROP collected_volumes, DROP volumes_read');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga_user DROP FOREIGN KEY FK_D2C73F03A76ED395');
        $this->addSql('ALTER TABLE manga_user DROP FOREIGN KEY FK_D2C73F037B6461');
        $this->addSql('DROP TABLE manga_user');
        $this->addSql('ALTER TABLE manga ADD collected TINYINT(1) NOT NULL, ADD readed TINYINT(1) NOT NULL, ADD collected_volumes INT NOT NULL, ADD volumes_read INT NOT NULL');
    }
}
