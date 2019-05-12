<?php

use yii\db\Migration;

/**
 * Class m190425_103819_base_i18n
 */
class m190425_103819_base_i18n extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Gender i18N table
        $this->execute("
            CREATE TABLE IF NOT EXISTS `gender_i18n` (
              `id` INT NOT NULL,
              `language_id` INT NOT NULL,
              `name` VARCHAR(45) NOT NULL,
              PRIMARY KEY (`id`, `language_id`),
              INDEX `FK_GENDER_I18N_LANGUAGE_ID_idx` (`language_id` ASC),
              CONSTRAINT `FK_GENDER_I18N_ID`
                FOREIGN KEY (`id`)
                REFERENCES `gender` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_GENDER_I18N_LANGUAGE_ID`
                FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // Language i18N table
        $this->execute("
            CREATE TABLE IF NOT EXISTS `language_i18n` (
              `id` INT NOT NULL,
              `language_id` INT NOT NULL,
              `name` VARCHAR(45) NOT NULL,
              PRIMARY KEY (`id`, `language_id`),
              INDEX `FK_LANGUAGE_I18N_Language_ID_idx` (`language_id` ASC),
              CONSTRAINT `FK_LANGUAGE_I18N_ID`
                FOREIGN KEY (`id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_LANGUAGE_I18N_Language_ID`
                FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // Nationality i18N table
        $this->execute("
            CREATE TABLE IF NOT EXISTS `nationality_i18n` (
              `id` INT NOT NULL,
              `language_id` INT NOT NULL,
              `name` VARCHAR(255) NOT NULL,
              `synonym_m` VARCHAR(255) NOT NULL,
              `synonym_w` VARCHAR(255) NOT NULL,
              `synonym_d` VARCHAR(45) NULL,
              PRIMARY KEY (`id`, `language_id`),
              INDEX `FK_NATIONALITY_I18N_LANGUAGE_ID_idx` (`language_id` ASC),
              CONSTRAINT `FK_NATIONALITY_I18N_ID`
                FOREIGN KEY (`id`)
                REFERENCES `nationality` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_NATIONALITY_I18N_LANGUAGE_ID`
                FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // reset nationality i18n table
        $this->dropTable('nationality_i18n');

        // reset language i18n table
        $this->dropTable('language_i18n');

        // reset gender i18n table
        $this->dropTable('gender_i18n');
    }
}
