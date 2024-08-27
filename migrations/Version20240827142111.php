<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827142111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gpostule (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_5643AD7CA76ED395 (user_id), INDEX IDX_5643AD7C8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gpostule ADD CONSTRAINT FK_5643AD7CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE gpostule ADD CONSTRAINT FK_5643AD7C8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonces (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gpostule DROP FOREIGN KEY FK_5643AD7CA76ED395');
        $this->addSql('ALTER TABLE gpostule DROP FOREIGN KEY FK_5643AD7C8805AB2F');
        $this->addSql('DROP TABLE gpostule');
    }
}
