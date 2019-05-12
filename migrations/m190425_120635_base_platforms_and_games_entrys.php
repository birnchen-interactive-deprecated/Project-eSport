<?php

use yii\db\Migration;

/**
 * Class m190425_120635_base_platforms_and_games_entrys
 */
class m190425_120635_base_platforms_and_games_entrys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Games base as standard German */
        $this->insert('games',  [
            'name' => 'Rocket League',
            'description' => 'Rocket League powerd by Psyonix, das Spiel des jahrhunderts',
            'twitter_developer' => '@PsyonixStudios',
            'twitter_game' => '@RocketLeague',
            'twitter_channel' => '#rocketleague'
        ]);

        $this->insert('games',  [
            'name' => 'Fortnite',
            'description' => 'Fortnite powerd by Epic Games, das Spiel des jahrhunderts',
            'twitter_developer' => '@EpicGames',
            'twitter_game' => '@FortniteGame',
            'twitter_channel' => '#Fortnite'
        ]);

        $this->insert('games',  [
            'name' => 'Mario Kart 8 Deluxe',
            'description' => 'Mario Kart 8 Deluxe powerd by Nintendo, das Spiel des jahrhunderts',
            'twitter_developer' => '@NintendoEurope',
            'twitter_game' => '@MarioKart8DLX',
            'twitter_channel' => '#MarioKart8Deluxe'
        ]);

        $this->insert('games',  [
            'name' => 'Splatoon 2',
            'description' => 'Splatoon 2 powerd by Nintendo, das Spiel des jahrhunderts',
            'twitter_developer' => '@NintendoEurope',
            'twitter_game' => '@SplatoonNews',
            'twitter_channel' => '#Splatoon2'
        ]);

        $this->insert('games',  [
            'name' => 'Super Smash Bros Ultimate',
            'description' => 'Super Smash Bros Ultimate powerd by Nintendo, das Spiel des jahrhunderts',
            'twitter_developer' => '@NintendoEurope',
            'twitter_game' => '@SSBUNews',
            'twitter_channel' => '#SSBU'
        ]);

        /* platforms base as standard German */
        $this->insert('platforms',  [
            'name' => 'Steam',
            'description' => 'Steam Client für nerdige PC Spieler'
        ]);

        $this->insert('platforms',  [
            'name' => 'Nintendo Switch',
            'description' => 'Switch Handheld Konsole um ausgiebig zu Spielen'
        ]);

        $this->insert('platforms',  [
            'name' => 'XBox One',
            'description' => 'Die XBox One Console, nicht schlecht, aber geht besser'
        ]);

        $this->insert('platforms',  [
            'name' => 'PS4',
            'description' => 'Playstation 4, war früher mal besser'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // reset platforms table
        $this->dropTable('platforms');
        $this->execute("
          CREATE TABLE IF NOT EXISTS `platforms` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            `description` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `id_UNIQUE` (`id` ASC))
          ENGINE = InnoDB");

        // reset games table
        $this->dropTable('games');
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
    }
}
