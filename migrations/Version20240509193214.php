<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509193214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY id_job');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY id_jobseeker');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, recruiter_id INT NOT NULL, position VARCHAR(255) NOT NULL, description VARCHAR(1000) NOT NULL, entreprise VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, employment_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', category VARCHAR(255) NOT NULL, INDEX IDX_FBD8E0F8156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, user_type VARCHAR(255) NOT NULL, job VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, image_url VARCHAR(500) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', personal_info VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8156BE243 FOREIGN KEY (recruiter_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE jobs DROP FOREIGN KEY id_recruiter');
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE application MODIFY id_app INT NOT NULL');
        $this->addSql('DROP INDEX id_jobseeker ON application');
        $this->addSql('DROP INDEX id_job ON application');
        $this->addSql('DROP INDEX `primary` ON application');
        $this->addSql('ALTER TABLE application ADD job_id INT NOT NULL, ADD jobseeker_id INT NOT NULL, DROP id_job, DROP id_jobseeker, CHANGE motivation motivation VARCHAR(1000) NOT NULL, CHANGE id_app id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC14CF2B5A9 FOREIGN KEY (jobseeker_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC1BE04EA9 ON application (job_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC14CF2B5A9 ON application (jobseeker_id)');
        $this->addSql('ALTER TABLE application ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1BE04EA9');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC14CF2B5A9');
        $this->addSql('CREATE TABLE jobs (id_job INT AUTO_INCREMENT NOT NULL, id_recruiter INT NOT NULL, position VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, entreprise VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, location VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, employment_type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, category VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_recruiter (id_recruiter), PRIMARY KEY(id_job)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id_user INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, last_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, password VARCHAR(250) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, user_type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, job VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, city VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, info_personnelles VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image_url VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT id_recruiter FOREIGN KEY (id_recruiter) REFERENCES users (id_user) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8156BE243');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE application MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_A45BDDC1BE04EA9 ON application');
        $this->addSql('DROP INDEX IDX_A45BDDC14CF2B5A9 ON application');
        $this->addSql('DROP INDEX `PRIMARY` ON application');
        $this->addSql('ALTER TABLE application ADD id_job INT NOT NULL, ADD id_jobseeker INT NOT NULL, DROP job_id, DROP jobseeker_id, CHANGE motivation motivation VARCHAR(500) NOT NULL, CHANGE id id_app INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT id_jobseeker FOREIGN KEY (id_jobseeker) REFERENCES users (id_user) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT id_job FOREIGN KEY (id_job) REFERENCES jobs (id_job) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX id_jobseeker ON application (id_jobseeker)');
        $this->addSql('CREATE INDEX id_job ON application (id_job)');
        $this->addSql('ALTER TABLE application ADD PRIMARY KEY (id_app)');
    }
}
