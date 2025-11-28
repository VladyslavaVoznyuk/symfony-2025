<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251128121510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D9119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_6DE30D9119EB6921 ON attendance (client_id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91613FECDF ON attendance (session_id)');
        $this->addSql('ALTER TABLE client ADD password VARCHAR(255) NOT NULL, ADD roles JSON NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('ALTER TABLE client_programs ADD CONSTRAINT FK_DFAF558019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_programs ADD CONSTRAINT FK_DFAF55803EB8070A FOREIGN KEY (program_id) REFERENCES programs (id)');
        $this->addSql('CREATE INDEX IDX_DFAF558019EB6921 ON client_programs (client_id)');
        $this->addSql('CREATE INDEX IDX_DFAF55803EB8070A ON client_programs (program_id)');
        $this->addSql('ALTER TABLE client_session ADD CONSTRAINT FK_827991A919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_session ADD CONSTRAINT FK_827991A9613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_827991A919EB6921 ON client_session (client_id)');
        $this->addSql('CREATE INDEX IDX_827991A9613FECDF ON client_session (session_id)');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B3219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_65D29B3219EB6921 ON payments (client_id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D43EB8070A FOREIGN KEY (program_id) REFERENCES programs (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4FB08EDF6 FOREIGN KEY (trainer_id) REFERENCES trainers (id)');
        $this->addSql('CREATE INDEX IDX_D044D5D43EB8070A ON session (program_id)');
        $this->addSql('CREATE INDEX IDX_D044D5D4FB08EDF6 ON session (trainer_id)');
        $this->addSql('ALTER TABLE trainer_programs ADD CONSTRAINT FK_FA5E855DFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES trainers (id)');
        $this->addSql('ALTER TABLE trainer_programs ADD CONSTRAINT FK_FA5E855D3EB8070A FOREIGN KEY (program_id) REFERENCES programs (id)');
        $this->addSql('CREATE INDEX IDX_FA5E855DFB08EDF6 ON trainer_programs (trainer_id)');
        $this->addSql('CREATE INDEX IDX_FA5E855D3EB8070A ON trainer_programs (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D9119EB6921');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91613FECDF');
        $this->addSql('DROP INDEX IDX_6DE30D9119EB6921 ON attendance');
        $this->addSql('DROP INDEX IDX_6DE30D91613FECDF ON attendance');
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74 ON client');
        $this->addSql('ALTER TABLE client DROP password, DROP roles');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D43EB8070A');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4FB08EDF6');
        $this->addSql('DROP INDEX IDX_D044D5D43EB8070A ON session');
        $this->addSql('DROP INDEX IDX_D044D5D4FB08EDF6 ON session');
        $this->addSql('ALTER TABLE client_programs DROP FOREIGN KEY FK_DFAF558019EB6921');
        $this->addSql('ALTER TABLE client_programs DROP FOREIGN KEY FK_DFAF55803EB8070A');
        $this->addSql('DROP INDEX IDX_DFAF558019EB6921 ON client_programs');
        $this->addSql('DROP INDEX IDX_DFAF55803EB8070A ON client_programs');
        $this->addSql('ALTER TABLE payments DROP FOREIGN KEY FK_65D29B3219EB6921');
        $this->addSql('DROP INDEX IDX_65D29B3219EB6921 ON payments');
        $this->addSql('ALTER TABLE client_session DROP FOREIGN KEY FK_827991A919EB6921');
        $this->addSql('ALTER TABLE client_session DROP FOREIGN KEY FK_827991A9613FECDF');
        $this->addSql('DROP INDEX IDX_827991A919EB6921 ON client_session');
        $this->addSql('DROP INDEX IDX_827991A9613FECDF ON client_session');
        $this->addSql('ALTER TABLE trainer_programs DROP FOREIGN KEY FK_FA5E855DFB08EDF6');
        $this->addSql('ALTER TABLE trainer_programs DROP FOREIGN KEY FK_FA5E855D3EB8070A');
        $this->addSql('DROP INDEX IDX_FA5E855DFB08EDF6 ON trainer_programs');
        $this->addSql('DROP INDEX IDX_FA5E855D3EB8070A ON trainer_programs');
    }
}
