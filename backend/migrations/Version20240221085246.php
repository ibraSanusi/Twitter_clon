<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221085246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE like_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C7F9184FA76ED395 (user_id), INDEX IDX_C7F9184FF8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retweet_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, INDEX IDX_65F4FC18A76ED395 (user_id), INDEX IDX_65F4FC18F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE like_comment ADD CONSTRAINT FK_C7F9184FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE like_comment ADD CONSTRAINT FK_C7F9184FF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE retweet_comment ADD CONSTRAINT FK_65F4FC18A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE retweet_comment ADD CONSTRAINT FK_65F4FC18F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE like_comment DROP FOREIGN KEY FK_C7F9184FA76ED395');
        $this->addSql('ALTER TABLE like_comment DROP FOREIGN KEY FK_C7F9184FF8697D13');
        $this->addSql('ALTER TABLE retweet_comment DROP FOREIGN KEY FK_65F4FC18A76ED395');
        $this->addSql('ALTER TABLE retweet_comment DROP FOREIGN KEY FK_65F4FC18F8697D13');
        $this->addSql('DROP TABLE like_comment');
        $this->addSql('DROP TABLE retweet_comment');
    }
}
