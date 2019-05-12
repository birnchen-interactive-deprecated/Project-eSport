<?php

use yii\db\Migration;

/**
 * Class m190425_120642_base_platforms_and_games_i18n
 */
class m190425_120642_base_platforms_and_games_i18n extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Games i18n
        $this->execute("
          CREATE TABLE IF NOT EXISTS `games_i18n` (
            `id` INT NOT NULL,
            `language_id` INT NOT NULL,
            `name` VARCHAR(45) NOT NULL,
            `description` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`, `language_id`),
            INDEX `FK_GAMES_I18N_LANGUAGE_ID_idx` (`language_id` ASC),
            CONSTRAINT `FK_GAMES_I18N_ID`
              FOREIGN KEY (`id`)
              REFERENCES `games` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `FK_GAMES_I18N_LANGUAGE_ID`
              FOREIGN KEY (`language_id`)
              REFERENCES `language` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE)
          ENGINE = InnoDB");

        // Platforms
        $this->execute("
          CREATE TABLE IF NOT EXISTS `platforms_i18n` (
            `id` INT NOT NULL,
            `language_id` INT NOT NULL,
            `name` VARCHAR(45) NOT NULL,
            `description` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`, `language_id`),
            INDEX `FK_PLATFORMS_I18N_LANGUAGE_ID_idx` (`language_id` ASC),
            CONSTRAINT `FK_PLATFORMS_I18N_ID`
              FOREIGN KEY (`id`)
              REFERENCES `platforms` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `FK_PLATFORMS_I18N_LANGUAGE_ID`
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
        $this->dropTable('platforms_i18n');
        $this->dropTable('games_i18n');
    }
}
