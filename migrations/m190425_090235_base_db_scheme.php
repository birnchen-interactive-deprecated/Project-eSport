<?php

use yii\db\Migration;

/**
 * Class m190425_090235_base_db_scheme
 */
class m190425_090235_base_db_scheme extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Gender
        $this->execute("
          CREATE TABLE IF NOT EXISTS `gender` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            UNIQUE INDEX `gender_id_UNIQUE` (`id` ASC),
            PRIMARY KEY (`id`))
          ENGINE = InnoDB");

        // Language
        $this->execute("
          CREATE TABLE IF NOT EXISTS `language` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            `locale` VARCHAR(45) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `language_id_UNIQUE` (`id` ASC))
          ENGINE = InnoDB");

        // Nationality
        $this->execute("
          CREATE TABLE IF NOT EXISTS `nationality` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `synonym_m` VARCHAR(255) NOT NULL,
            `synonym_w` VARCHAR(255) NOT NULL,
            `synonym_d` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `nationality_id_UNIQUE` (`id` ASC),
            UNIQUE INDEX `name_UNIQUE` (`name` ASC))
          ENGINE = InnoDB");

        // User
        $this->execute("
          CREATE TABLE IF NOT EXISTS `user` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `birthday` DATE NOT NULL,
            `gender_id` INT NOT NULL,
            `language_id` INT NOT NULL,
            `nationality_id` INT NOT NULL,
            `pre_name` VARCHAR(255) NULL,
            `last_name` VARCHAR(255) NULL,
            `zip_code` VARCHAR(255) NULL,
            `city` VARCHAR(255) NULL,
            `street` VARCHAR(255) NULL,
            `dt_created` DATETIME NOT NULL,
            `dt_updated` DATETIME NOT NULL,
            `is_password_change_required` TINYINT(4) NULL DEFAULT 0,
            `access_token` VARCHAR(255) NOT NULL,
            `auth_key` VARCHAR(255) NOT NULL,
            `twitter_account` VARCHAR(255) NULL,
            `twitter_channel` VARCHAR(255) NULL,
            `discord_id` VARCHAR(255) NULL,
            `discord_server` VARCHAR(255) NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `user_id_UNIQUE` (`id` ASC),
            UNIQUE INDEX `username_UNIQUE` (`username` ASC),
            UNIQUE INDEX `email_UNIQUE` (`email` ASC),
            INDEX `FK_USER_GENDER_ID_idx` (`gender_id` ASC),
            INDEX `FK_USER_LANGUAGE_ID_idx` (`language_id` ASC),
            INDEX `FK_USER_NATIONALITY_ID_idx` (`nationality_id` ASC),
            UNIQUE INDEX `twitter_account_UNIQUE` (`twitter_account` ASC),
            UNIQUE INDEX `twitter_channel_UNIQUE` (`twitter_channel` ASC),
            UNIQUE INDEX `Discord_id_UNIQUE` (`Discord_id` ASC),
            UNIQUE INDEX `Discord_Server_UNIQUE` (`Discord_Server` ASC),
            CONSTRAINT `FK_USER_GENDER_ID`
              FOREIGN KEY (`gender_id`)
              REFERENCES `gender` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `FK_USER_LANGUAGE_ID`
              FOREIGN KEY (`language_id`)
              REFERENCES `language` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `FK_USER_NATIONALITY_ID`
              FOREIGN KEY (`nationality_id`)
              REFERENCES `nationality` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE)
          ENGINE = InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
        $this->dropTable('nationality');
        $this->dropTable('language');
        $this->dropTable('gender');
    }
}
