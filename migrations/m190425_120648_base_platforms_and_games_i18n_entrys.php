<?php

use yii\db\Migration;

/**
 * Class m190425_120648_base_platforms_and_games_i18n_entrys
 */
class m190425_120648_base_platforms_and_games_i18n_entrys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Games i18n English */
        $this->insert('games_i18n',  [
            'id' => '1',
            'language_id' => '2',
            'name' => 'Rocket League',
            'description' => 'Rocket League powerd by Psyonix, the Millenium game'
        ]);

        /* Platforms i18n English */
        $this->insert('platforms_i18n',  [
            'id' => '1',
            'language_id' => '2',
            'name' => 'Steam',
            'description' => 'Steam Client for nerdic gamers'
        ]);

        $this->insert('platforms_i18n',  [
            'id' => '2',
            'language_id' => '2',
            'name' => 'Nintendo Switch',
            'description' => 'Switch Handheld Console for epic fun'
        ]);

        $this->insert('platforms_i18n',  [
            'id' => '3',
            'language_id' => '2',
            'name' => 'XBox One',
            'description' => 'Die XBox One Console, not bad, but could be better'
        ]);

        $this->insert('platforms_i18n',  [
            'id' => '4',
            'language_id' => '2',
            'name' => 'Playstation',
            'description' => 'Playstation 4, in the early 2000 it was a better console then now'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // reset games i18n
        $this->dropForeignKey(
            'FK_PLATFORMS_I18N_ID',
            'platforms_i18n'
        );
        $this->dropForeignKey(
            'FK_PLATFORMS_I18N_LANGUAGE_ID',
            'platforms_i18n'
        );
        $this->dropTable('platforms_i18n');
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

        // reset platforms i18n
        $this->dropForeignKey(
            'FK_GAMES_I18N_ID',
            'games_i18n'
        );
        $this->dropForeignKey(
            'FK_GAMES_I18N_LANGUAGE_ID',
            'games_i18n'
        );
        $this->dropTable('games_i18n');
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
    }
}
