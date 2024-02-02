<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201190242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE follower (id INT AUTO_INCREMENT NOT NULL, followed_id_id INT DEFAULT NULL, following_id_id INT DEFAULT NULL, following_date DATETIME NOT NULL, INDEX IDX_B9D60946ECD373E5 (followed_id_id), INDEX IDX_B9D609463CF8336F (following_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, tweet_id_id INT NOT NULL, like_date DATETIME NOT NULL, INDEX IDX_AC6340B39D86650F (user_id_id), INDEX IDX_AC6340B3E38F4318 (tweet_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retweet (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, tweet_id_id INT DEFAULT NULL, retweet_date DATETIME NOT NULL, INDEX IDX_45E67DB39D86650F (user_id_id), INDEX IDX_45E67DB3E38F4318 (tweet_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tweet (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, content VARCHAR(255) NOT NULL, publish_date DATETIME NOT NULL, INDEX IDX_3D660A3B9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D60946ECD373E5 FOREIGN KEY (followed_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D609463CF8336F FOREIGN KEY (following_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B39D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3E38F4318 FOREIGN KEY (tweet_id_id) REFERENCES tweet (id)');
        $this->addSql('ALTER TABLE retweet ADD CONSTRAINT FK_45E67DB39D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE retweet ADD CONSTRAINT FK_45E67DB3E38F4318 FOREIGN KEY (tweet_id_id) REFERENCES tweet (id)');
        $this->addSql('ALTER TABLE tweet ADD CONSTRAINT FK_3D660A3B9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D60946ECD373E5');
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D609463CF8336F');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B39D86650F');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3E38F4318');
        $this->addSql('ALTER TABLE retweet DROP FOREIGN KEY FK_45E67DB39D86650F');
        $this->addSql('ALTER TABLE retweet DROP FOREIGN KEY FK_45E67DB3E38F4318');
        $this->addSql('ALTER TABLE tweet DROP FOREIGN KEY FK_3D660A3B9D86650F');
        $this->addSql('DROP TABLE follower');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE retweet');
        $this->addSql('DROP TABLE tweet');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
