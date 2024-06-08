<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240608125659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manga ADD category_id INT NOT NULL, ADD editor_id INT NOT NULL, ADD author_id INT NOT NULL, ADD status_id INT NOT NULL, ADD readed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E0312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E036995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id)');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E03F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E036BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_765A9E0312469DE2 ON manga (category_id)');
        $this->addSql('CREATE INDEX IDX_765A9E036995AC4C ON manga (editor_id)');
        $this->addSql('CREATE INDEX IDX_765A9E03F675F31B ON manga (author_id)');
        $this->addSql('CREATE INDEX IDX_765A9E036BF700BD ON manga (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E03F675F31B');
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E0312469DE2');
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E036995AC4C');
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E036BF700BD');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE editor');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP INDEX IDX_765A9E0312469DE2 ON manga');
        $this->addSql('DROP INDEX IDX_765A9E036995AC4C ON manga');
        $this->addSql('DROP INDEX IDX_765A9E03F675F31B ON manga');
        $this->addSql('DROP INDEX IDX_765A9E036BF700BD ON manga');
        $this->addSql('ALTER TABLE manga DROP category_id, DROP editor_id, DROP author_id, DROP status_id, DROP readed');
    }
}
