<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229223117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, tweet_id INT DEFAULT NULL, author_id INT NOT NULL, content VARCHAR(255) NOT NULL, parent_comment INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C1041E39B (tweet_id), INDEX IDX_9474526CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE follower (id INT AUTO_INCREMENT NOT NULL, follower_id INT DEFAULT NULL, following_id INT DEFAULT NULL, following_date DATETIME NOT NULL, INDEX IDX_B9D60946AC24F853 (follower_id), INDEX IDX_B9D609461816E3A3 (following_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tweet_id INT NOT NULL, like_date DATETIME NOT NULL, INDEX IDX_AC6340B3A76ED395 (user_id), INDEX IDX_AC6340B31041E39B (tweet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE like_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_C7F9184FA76ED395 (user_id), INDEX IDX_C7F9184FF8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retweet (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tweet_id INT DEFAULT NULL, retweet_date DATETIME NOT NULL, INDEX IDX_45E67DB3A76ED395 (user_id), INDEX IDX_45E67DB31041E39B (tweet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retweet_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_65F4FC18A76ED395 (user_id), INDEX IDX_65F4FC18F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tweet (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, content VARCHAR(255) NOT NULL, publish_date DATETIME NOT NULL, INDEX IDX_3D660A3BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1041E39B FOREIGN KEY (tweet_id) REFERENCES tweet (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D60946AC24F853 FOREIGN KEY (follower_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D609461816E3A3 FOREIGN KEY (following_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B31041E39B FOREIGN KEY (tweet_id) REFERENCES tweet (id)');
        $this->addSql('ALTER TABLE like_comment ADD CONSTRAINT FK_C7F9184FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE like_comment ADD CONSTRAINT FK_C7F9184FF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE retweet ADD CONSTRAINT FK_45E67DB3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE retweet ADD CONSTRAINT FK_45E67DB31041E39B FOREIGN KEY (tweet_id) REFERENCES tweet (id)');
        $this->addSql('ALTER TABLE retweet_comment ADD CONSTRAINT FK_65F4FC18A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE retweet_comment ADD CONSTRAINT FK_65F4FC18F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE tweet ADD CONSTRAINT FK_3D660A3BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C1041E39B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D60946AC24F853');
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D609461816E3A3');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B31041E39B');
        $this->addSql('ALTER TABLE like_comment DROP FOREIGN KEY FK_C7F9184FA76ED395');
        $this->addSql('ALTER TABLE like_comment DROP FOREIGN KEY FK_C7F9184FF8697D13');
        $this->addSql('ALTER TABLE retweet DROP FOREIGN KEY FK_45E67DB3A76ED395');
        $this->addSql('ALTER TABLE retweet DROP FOREIGN KEY FK_45E67DB31041E39B');
        $this->addSql('ALTER TABLE retweet_comment DROP FOREIGN KEY FK_65F4FC18A76ED395');
        $this->addSql('ALTER TABLE retweet_comment DROP FOREIGN KEY FK_65F4FC18F8697D13');
        $this->addSql('ALTER TABLE tweet DROP FOREIGN KEY FK_3D660A3BA76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE follower');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE like_comment');
        $this->addSql('DROP TABLE retweet');
        $this->addSql('DROP TABLE retweet_comment');
        $this->addSql('DROP TABLE tweet');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
