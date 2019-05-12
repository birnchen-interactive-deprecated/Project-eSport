<?php

use yii\db\Migration;

/**
 * Class m190425_120609_base_platforms_and_games
 */
class m190425_120609_base_platforms_and_games extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Games
        $this->execute("
          CREATE TABLE IF NOT EXISTS `games` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            `description` VARCHAR(255) NOT NULL,
            `twitter_developer` VARCHAR(255) NULL,
            `twitter_game` VARCHAR(255) NULL,
            `twitter_channel` VARCHAR(255) NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `id_UNIQUE` (`id` ASC),
            UNIQUE INDEX `twitter_game_UNIQUE` (`twitter_game` ASC))
          ENGINE = InnoDB");

        // Platforms
        $this->execute("
          CREATE TABLE IF NOT EXISTS `platforms` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            `description` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `id_UNIQUE` (`id` ASC))
          ENGINE = InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('games');
        $this->dropTable('platforms');
    }
}
