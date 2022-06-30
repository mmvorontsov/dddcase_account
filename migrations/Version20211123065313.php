<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123065313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE _contact_data (contact_data__id UUID NOT NULL, user__id UUID NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(contact_data__id))');
        $this->addSql('CREATE INDEX IDX_DF5713358D57A4BB ON _contact_data (user__id)');
        $this->addSql('CREATE UNIQUE INDEX email_unique ON _contact_data (email) WHERE (email IS NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX phone_unique ON _contact_data (phone) WHERE (phone IS NOT NULL)');
        $this->addSql('COMMENT ON COLUMN _contact_data.contact_data__id IS \'(DC2Type:contact_data__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data.user__id IS \'(DC2Type:user__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data.email IS \'(DC2Type:email_address)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data.phone IS \'(DC2Type:phone_number)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _contact_data__email_history (uuid UUID NOT NULL, contact_data__id UUID DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, replaced_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_5671987CB8E8B812 ON _contact_data__email_history (contact_data__id)');
        $this->addSql('COMMENT ON COLUMN _contact_data__email_history.uuid IS \'(DC2Type:_uuid)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data__email_history.contact_data__id IS \'(DC2Type:contact_data__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data__email_history.email IS \'(DC2Type:email_address)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data__email_history.replaced_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _contact_data__phone_history (uuid UUID NOT NULL, contact_data__id UUID DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, replaced_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_7BF37C81B8E8B812 ON _contact_data__phone_history (contact_data__id)');
        $this->addSql('COMMENT ON COLUMN _contact_data__phone_history.uuid IS \'(DC2Type:_uuid)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data__phone_history.contact_data__id IS \'(DC2Type:contact_data__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data__phone_history.phone IS \'(DC2Type:phone_number)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data__phone_history.replaced_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _contact_data_change (contact_data_change__id UUID NOT NULL, user__id UUID NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(contact_data_change__id))');
        $this->addSql('COMMENT ON COLUMN _contact_data_change.contact_data_change__id IS \'(DC2Type:contact_data_change__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data_change.user__id IS \'(DC2Type:user__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data_change.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data_change.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _contact_data_change__key_maker (key_maker__id UUID NOT NULL, contact_data_change__id UUID NOT NULL, PRIMARY KEY(key_maker__id))');
        $this->addSql('COMMENT ON COLUMN _contact_data_change__key_maker.key_maker__id IS \'(DC2Type:key_maker__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data_change__key_maker.contact_data_change__id IS \'(DC2Type:contact_data_change__id)\'');
        $this->addSql('CREATE TABLE _contact_data_change_email (contact_data_change__id UUID NOT NULL, from_email VARCHAR(255) DEFAULT NULL, to_email VARCHAR(255) NOT NULL, PRIMARY KEY(contact_data_change__id))');
        $this->addSql('COMMENT ON COLUMN _contact_data_change_email.contact_data_change__id IS \'(DC2Type:contact_data_change__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data_change_email.from_email IS \'(DC2Type:email_address)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data_change_email.to_email IS \'(DC2Type:email_address)\'');
        $this->addSql('CREATE TABLE _contact_data_change_phone (contact_data_change__id UUID NOT NULL, from_phone VARCHAR(255) DEFAULT NULL, to_phone VARCHAR(255) NOT NULL, PRIMARY KEY(contact_data_change__id))');
        $this->addSql('COMMENT ON COLUMN _contact_data_change_phone.contact_data_change__id IS \'(DC2Type:contact_data_change__id)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data_change_phone.from_phone IS \'(DC2Type:phone_number)\'');
        $this->addSql('COMMENT ON COLUMN _contact_data_change_phone.to_phone IS \'(DC2Type:phone_number)\'');
        $this->addSql('CREATE TABLE _credential (credential__id UUID NOT NULL, user__id UUID NOT NULL, username VARCHAR(255) DEFAULT NULL, hashed_password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(credential__id))');
        $this->addSql('CREATE INDEX IDX_6634ED338D57A4BB ON _credential (user__id)');
        $this->addSql('CREATE UNIQUE INDEX username_unique ON _credential (username) WHERE (username IS NOT NULL)');
        $this->addSql('COMMENT ON COLUMN _credential.credential__id IS \'(DC2Type:credential__id)\'');
        $this->addSql('COMMENT ON COLUMN _credential.user__id IS \'(DC2Type:user__id)\'');
        $this->addSql('COMMENT ON COLUMN _credential.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _credential__password_history (uuid UUID NOT NULL, credential__id UUID DEFAULT NULL, hashed_password VARCHAR(255) NOT NULL, replaced_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_6D087CDBAB0CA263 ON _credential__password_history (credential__id)');
        $this->addSql('COMMENT ON COLUMN _credential__password_history.uuid IS \'(DC2Type:_uuid)\'');
        $this->addSql('COMMENT ON COLUMN _credential__password_history.credential__id IS \'(DC2Type:credential__id)\'');
        $this->addSql('COMMENT ON COLUMN _credential__password_history.replaced_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _credential_recovery (credential_recovery__id UUID NOT NULL, by_email VARCHAR(255) DEFAULT NULL, by_phone VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, user__id UUID DEFAULT NULL, password_entry_code VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(credential_recovery__id))');
        $this->addSql('COMMENT ON COLUMN _credential_recovery.credential_recovery__id IS \'(DC2Type:credential_recovery__id)\'');
        $this->addSql('COMMENT ON COLUMN _credential_recovery.by_email IS \'(DC2Type:email_address)\'');
        $this->addSql('COMMENT ON COLUMN _credential_recovery.by_phone IS \'(DC2Type:phone_number)\'');
        $this->addSql('COMMENT ON COLUMN _credential_recovery.user__id IS \'(DC2Type:user__id)\'');
        $this->addSql('COMMENT ON COLUMN _credential_recovery.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN _credential_recovery.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _credential_recovery__key_maker (key_maker__id UUID NOT NULL, credential_recovery__id UUID NOT NULL, PRIMARY KEY(key_maker__id))');
        $this->addSql('COMMENT ON COLUMN _credential_recovery__key_maker.key_maker__id IS \'(DC2Type:key_maker__id)\'');
        $this->addSql('COMMENT ON COLUMN _credential_recovery__key_maker.credential_recovery__id IS \'(DC2Type:credential_recovery__id)\'');
        $this->addSql('CREATE TABLE _inbox (inbox__id UUID NOT NULL, message_name VARCHAR(255) NOT NULL, processing_time DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(inbox__id))');
        $this->addSql('COMMENT ON COLUMN _inbox.inbox__id IS \'(DC2Type:inbox__id)\'');
        $this->addSql('COMMENT ON COLUMN _inbox.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _key_maker (key_maker__id UUID NOT NULL, secret_codes_limit INT NOT NULL, is_mute BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, recipient_email VARCHAR(255) DEFAULT NULL, recipient_phone VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(key_maker__id))');
        $this->addSql('COMMENT ON COLUMN _key_maker.key_maker__id IS \'(DC2Type:key_maker__id)\'');
        $this->addSql('COMMENT ON COLUMN _key_maker.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN _key_maker.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN _key_maker.recipient_email IS \'(DC2Type:email_address)\'');
        $this->addSql('COMMENT ON COLUMN _key_maker.recipient_phone IS \'(DC2Type:phone_number)\'');
        $this->addSql('CREATE TABLE _key_maker__secret_code (uuid UUID NOT NULL, key_maker__id UUID DEFAULT NULL, code VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, acceptance_attempts INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_E1FD9FEC7256798D ON _key_maker__secret_code (key_maker__id)');
        $this->addSql('COMMENT ON COLUMN _key_maker__secret_code.uuid IS \'(DC2Type:_uuid)\'');
        $this->addSql('COMMENT ON COLUMN _key_maker__secret_code.key_maker__id IS \'(DC2Type:key_maker__id)\'');
        $this->addSql('COMMENT ON COLUMN _key_maker__secret_code.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN _key_maker__secret_code.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _outbox (outbox__id UUID NOT NULL, type VARCHAR(255) NOT NULL, data JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(outbox__id))');
        $this->addSql('COMMENT ON COLUMN _outbox.outbox__id IS \'(DC2Type:outbox__id)\'');
        $this->addSql('COMMENT ON COLUMN _outbox.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _permission (permission__id VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, PRIMARY KEY(permission__id))');
        $this->addSql('COMMENT ON COLUMN _permission.permission__id IS \'(DC2Type:permission__id)\'');
        $this->addSql('CREATE TABLE _registration (registration__id UUID NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, personal_data_firstname VARCHAR(255) NOT NULL, personal_data_hashed_password VARCHAR(255) NOT NULL, personal_data_email VARCHAR(255) NOT NULL, PRIMARY KEY(registration__id))');
        $this->addSql('COMMENT ON COLUMN _registration.registration__id IS \'(DC2Type:registration__id)\'');
        $this->addSql('COMMENT ON COLUMN _registration.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN _registration.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN _registration.personal_data_email IS \'(DC2Type:email_address)\'');
        $this->addSql('CREATE TABLE _registration__key_maker (key_maker__id UUID NOT NULL, registration__id UUID NOT NULL, PRIMARY KEY(key_maker__id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F430A6AE2C38006 ON _registration__key_maker (registration__id)');
        $this->addSql('COMMENT ON COLUMN _registration__key_maker.key_maker__id IS \'(DC2Type:key_maker__id)\'');
        $this->addSql('COMMENT ON COLUMN _registration__key_maker.registration__id IS \'(DC2Type:registration__id)\'');
        $this->addSql('CREATE TABLE _role (role__id VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, PRIMARY KEY(role__id))');
        $this->addSql('COMMENT ON COLUMN _role.role__id IS \'(DC2Type:role__id)\'');
        $this->addSql('CREATE TABLE _role__permission (uuid UUID NOT NULL, role__id VARCHAR(255) DEFAULT NULL, permission__id VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_18944FEFD2234142 ON _role__permission (role__id)');
        $this->addSql('CREATE INDEX IDX_18944FEF76DA5F01 ON _role__permission (permission__id)');
        $this->addSql('CREATE UNIQUE INDEX _role__permission_unique_group ON _role__permission (role__id, permission__id)');
        $this->addSql('COMMENT ON COLUMN _role__permission.uuid IS \'(DC2Type:_uuid)\'');
        $this->addSql('COMMENT ON COLUMN _role__permission.role__id IS \'(DC2Type:role__id)\'');
        $this->addSql('COMMENT ON COLUMN _role__permission.permission__id IS \'(DC2Type:permission__id)\'');
        $this->addSql('CREATE TABLE _user (user__id UUID NOT NULL, firstname VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(user__id))');
        $this->addSql('COMMENT ON COLUMN _user.user__id IS \'(DC2Type:user__id)\'');
        $this->addSql('COMMENT ON COLUMN _user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE _user__role (uuid UUID NOT NULL, user__id UUID DEFAULT NULL, role__id VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_8BC5F1518D57A4BB ON _user__role (user__id)');
        $this->addSql('CREATE INDEX IDX_8BC5F151D2234142 ON _user__role (role__id)');
        $this->addSql('CREATE UNIQUE INDEX _user__role_unique_group ON _user__role (user__id, role__id)');
        $this->addSql('COMMENT ON COLUMN _user__role.uuid IS \'(DC2Type:_uuid)\'');
        $this->addSql('COMMENT ON COLUMN _user__role.user__id IS \'(DC2Type:user__id)\'');
        $this->addSql('COMMENT ON COLUMN _user__role.role__id IS \'(DC2Type:role__id)\'');
        $this->addSql('ALTER TABLE _contact_data__email_history ADD CONSTRAINT FK_5671987CB8E8B812 FOREIGN KEY (contact_data__id) REFERENCES _contact_data (contact_data__id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _contact_data__phone_history ADD CONSTRAINT FK_7BF37C81B8E8B812 FOREIGN KEY (contact_data__id) REFERENCES _contact_data (contact_data__id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _contact_data_change__key_maker ADD CONSTRAINT FK_30098627256798D FOREIGN KEY (key_maker__id) REFERENCES _key_maker (key_maker__id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _contact_data_change_email ADD CONSTRAINT FK_7F56DEC3E346A2CA FOREIGN KEY (contact_data_change__id) REFERENCES _contact_data_change (contact_data_change__id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _contact_data_change_phone ADD CONSTRAINT FK_DC8B356AE346A2CA FOREIGN KEY (contact_data_change__id) REFERENCES _contact_data_change (contact_data_change__id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _credential__password_history ADD CONSTRAINT FK_6D087CDBAB0CA263 FOREIGN KEY (credential__id) REFERENCES _credential (credential__id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _credential_recovery__key_maker ADD CONSTRAINT FK_2FB6C0057256798D FOREIGN KEY (key_maker__id) REFERENCES _key_maker (key_maker__id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _key_maker__secret_code ADD CONSTRAINT FK_E1FD9FEC7256798D FOREIGN KEY (key_maker__id) REFERENCES _key_maker (key_maker__id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _registration__key_maker ADD CONSTRAINT FK_3F430A6A7256798D FOREIGN KEY (key_maker__id) REFERENCES _key_maker (key_maker__id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _role__permission ADD CONSTRAINT FK_18944FEFD2234142 FOREIGN KEY (role__id) REFERENCES _role (role__id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE _user__role ADD CONSTRAINT FK_8BC5F1518D57A4BB FOREIGN KEY (user__id) REFERENCES _user (user__id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE _contact_data__email_history DROP CONSTRAINT FK_5671987CB8E8B812');
        $this->addSql('ALTER TABLE _contact_data__phone_history DROP CONSTRAINT FK_7BF37C81B8E8B812');
        $this->addSql('ALTER TABLE _contact_data_change_email DROP CONSTRAINT FK_7F56DEC3E346A2CA');
        $this->addSql('ALTER TABLE _contact_data_change_phone DROP CONSTRAINT FK_DC8B356AE346A2CA');
        $this->addSql('ALTER TABLE _credential__password_history DROP CONSTRAINT FK_6D087CDBAB0CA263');
        $this->addSql('ALTER TABLE _contact_data_change__key_maker DROP CONSTRAINT FK_30098627256798D');
        $this->addSql('ALTER TABLE _credential_recovery__key_maker DROP CONSTRAINT FK_2FB6C0057256798D');
        $this->addSql('ALTER TABLE _key_maker__secret_code DROP CONSTRAINT FK_E1FD9FEC7256798D');
        $this->addSql('ALTER TABLE _registration__key_maker DROP CONSTRAINT FK_3F430A6A7256798D');
        $this->addSql('ALTER TABLE _role__permission DROP CONSTRAINT FK_18944FEFD2234142');
        $this->addSql('ALTER TABLE _user__role DROP CONSTRAINT FK_8BC5F1518D57A4BB');
        $this->addSql('DROP TABLE _contact_data');
        $this->addSql('DROP TABLE _contact_data__email_history');
        $this->addSql('DROP TABLE _contact_data__phone_history');
        $this->addSql('DROP TABLE _contact_data_change');
        $this->addSql('DROP TABLE _contact_data_change__key_maker');
        $this->addSql('DROP TABLE _contact_data_change_email');
        $this->addSql('DROP TABLE _contact_data_change_phone');
        $this->addSql('DROP TABLE _credential');
        $this->addSql('DROP TABLE _credential__password_history');
        $this->addSql('DROP TABLE _credential_recovery');
        $this->addSql('DROP TABLE _credential_recovery__key_maker');
        $this->addSql('DROP TABLE _inbox');
        $this->addSql('DROP TABLE _key_maker');
        $this->addSql('DROP TABLE _key_maker__secret_code');
        $this->addSql('DROP TABLE _outbox');
        $this->addSql('DROP TABLE _permission');
        $this->addSql('DROP TABLE _registration');
        $this->addSql('DROP TABLE _registration__key_maker');
        $this->addSql('DROP TABLE _role');
        $this->addSql('DROP TABLE _role__permission');
        $this->addSql('DROP TABLE _user');
        $this->addSql('DROP TABLE _user__role');
    }
}
