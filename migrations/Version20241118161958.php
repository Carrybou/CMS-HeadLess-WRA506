<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118161958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', author_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', txt VARCHAR(255) NOT NULL, dcrt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, dmod DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, INDEX IDX_9474526CF675F31B (author_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', author_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, meta VARCHAR(255) DEFAULT NULL, content VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, dcrt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, dmod DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, INDEX IDX_FEC530A9F675F31B (author_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_tags (content_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tag_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_A2DE79E31C1DBD63 (content_uuid), INDEX IDX_A2DE79E33F70EF10 (tag_uuid), PRIMARY KEY(content_uuid, tag_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, dcrt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, dmod DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', roles JSON NOT NULL, password VARCHAR(255) NOT NULL, dcrt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, dmod DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, UNIQUE INDEX UNIQ_IDENTIFIER_UUID (uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES `user` (uuid)');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9F675F31B FOREIGN KEY (author_id) REFERENCES `user` (uuid)');
        $this->addSql('ALTER TABLE content_tags ADD CONSTRAINT FK_A2DE79E31C1DBD63 FOREIGN KEY (content_uuid) REFERENCES content (uuid)');
        $this->addSql('ALTER TABLE content_tags ADD CONSTRAINT FK_A2DE79E33F70EF10 FOREIGN KEY (tag_uuid) REFERENCES tags (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9F675F31B');
        $this->addSql('ALTER TABLE content_tags DROP FOREIGN KEY FK_A2DE79E31C1DBD63');
        $this->addSql('ALTER TABLE content_tags DROP FOREIGN KEY FK_A2DE79E33F70EF10');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_tags');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE `user`');
    }
}
