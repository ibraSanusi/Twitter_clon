<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202102051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D609463CF8336F');
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D60946ECD373E5');
        $this->addSql('DROP INDEX IDX_B9D60946ECD373E5 ON follower');
        $this->addSql('DROP INDEX IDX_B9D609463CF8336F ON follower');
        $this->addSql('ALTER TABLE follower ADD follower_id INT DEFAULT NULL, ADD following_id INT DEFAULT NULL, DROP followed_id_id, DROP following_id_id');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D60946AC24F853 FOREIGN KEY (follower_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D609461816E3A3 FOREIGN KEY (following_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B9D60946AC24F853 ON follower (follower_id)');
        $this->addSql('CREATE INDEX IDX_B9D609461816E3A3 ON follower (following_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D60946AC24F853');
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D609461816E3A3');
        $this->addSql('DROP INDEX IDX_B9D60946AC24F853 ON follower');
        $this->addSql('DROP INDEX IDX_B9D609461816E3A3 ON follower');
        $this->addSql('ALTER TABLE follower ADD followed_id_id INT DEFAULT NULL, ADD following_id_id INT DEFAULT NULL, DROP follower_id, DROP following_id');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D609463CF8336F FOREIGN KEY (following_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D60946ECD373E5 FOREIGN KEY (followed_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B9D60946ECD373E5 ON follower (followed_id_id)');
        $this->addSql('CREATE INDEX IDX_B9D609463CF8336F ON follower (following_id_id)');
    }
}
