<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120140405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES `user` (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9F675F31B');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9F675F31B FOREIGN KEY (author_id) REFERENCES `user` (uuid) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FEC530A9989D9B62 ON content (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9F675F31B');
        $this->addSql('DROP INDEX UNIQ_FEC530A9989D9B62 ON content');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9F675F31B FOREIGN KEY (author_id) REFERENCES user (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
