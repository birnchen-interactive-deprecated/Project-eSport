<?php

use yii\db\Migration;

/**
 * Class m190517_081725_tounament_cup_brackets
 */
class m190517_081725_tournament_cup_brackets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Cups
        $this->execute("
          CREATE TABLE IF NOT EXISTS `cup` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(255) NOT NULL,
              `season` VARCHAR(255) NOT NULL,
              `twitter_channel` VARCHAR(255) NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `ID_UNIQUE` (`id` ASC))
            ENGINE = InnoDB");

        // tournament bracket mode
        $this->execute("
          CREATE TABLE IF NOT EXISTS `tournament_bracket_mode` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(255) NOT NULL,
              `description` VARCHAR(255) NULL,
              `twitter_channel` VARCHAR(255) NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `id_UNIQUE` (`id` ASC),
              UNIQUE INDEX `name_UNIQUE` (`name` ASC))
            ENGINE = InnoDB");

        // tournaments
        $this->execute("
          CREATE TABLE IF NOT EXISTS `tournament` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `game_id` INT NOT NULL,
              `mode_id` INT NOT NULL,
              `bracket_mode_id` INT NOT NULL,
              `cup_id` INT NOT NULL,
              `rules_id` INT NOT NULL,
              `name` VARCHAR(255) NOT NULL,
              `description` VARCHAR(255) NULL,
              `dt_starting_time` DATETIME NOT NULL,
              `dt_register_open` DATETIME NOT NULL,
              `dt_register_close` DATETIME NOT NULL,
              `dt_checkin_open` DATETIME NOT NULL,
              `dt_checkin_close` DATETIME NOT NULL,
              `has_password` TINYINT(1) NOT NULL DEFAULT 0,
              `password` VARCHAR(255) NULL,
              `twitter_channel` VARCHAR(255) NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `id_UNIQUE` (`id` ASC),
              INDEX `FK_TOURNAMENT_GAME_ID_GAMES_ID_idx` (`game_id` ASC),
              INDEX `FK_TOURNAMENT_MODE_ID_TOURNAMENT_MODE_ID_idx` (`mode_id` ASC),
              INDEX `FK_TOURNAMENT_BRACKET_MODE_ID_BRACKET_MODE_ID_idx` (`bracket_mode_id` ASC),
              INDEX `FK_TOURNAMENT_CUP_ID_CUP_ID_idx` (`cup_id` ASC),
              CONSTRAINT `FK_TOURNAMENT_GAME_ID_GAMES_ID`
                FOREIGN KEY (`game_id`)
                REFERENCES `games` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_TOURNAMENT_MODE_ID_TOURNAMENT_MODE_ID`
                FOREIGN KEY (`mode_id`)
                REFERENCES `tournament_mode` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_TOURNAMENT_BRACKET_MODE_ID_BRACKET_MODE_ID`
                FOREIGN KEY (`bracket_mode_id`)
                REFERENCES `tournament_bracket_mode` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_TOURNAMENT_CUP_ID_CUP_ID`
                FOREIGN KEY (`cup_id`)
                REFERENCES `cup` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // player participating
        $this->execute("
          CREATE TABLE IF NOT EXISTS `player_participating` (
              `user_id` INT NOT NULL,
              `tournament_id` INT NOT NULL,
              `checked_in` TINYINT(1) NOT NULL DEFAULT 0,
              PRIMARY KEY (`user_id`, `tournament_id`),
              INDEX `FK_PLAYERPARTICIPATING_TOURNAMENT_ID_idx` (`tournament_id` ASC),
              CONSTRAINT `FK_PLAYER_PARTICIPATING_USER_ID`
                FOREIGN KEY (`user_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_PLAYERPARTICIPATING_TOURNAMENT_ID`
                FOREIGN KEY (`tournament_id`)
                REFERENCES `tournament` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // team participating
        $this->execute("
          CREATE TABLE IF NOT EXISTS `team_participating` (
              `sub_Team_id` INT NOT NULL,
              `tournament_id` INT NOT NULL,
              `checked_in` TINYINT(1) NOT NULL,
              PRIMARY KEY (`sub_Team_id`, `tournament_id`),
              INDEX `FK_TEAM_PARTICIPATING_TOURNAMENT_ID_idx` (`tournament_id` ASC),
              CONSTRAINT `FK_TEAM_PARTICIPATING_SUB_TEAM_ID`
                FOREIGN KEY (`sub_Team_id`)
                REFERENCES `sub_team` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_TEAM_PARTICIPATING_TOURNAMENT_ID`
                FOREIGN KEY (`tournament_id`)
                REFERENCES `tournament` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        /* Cup Base Netry */
        $this->insert('cup',  [
            'name' => 'GERTA Cup',
            'season' => 'Season 1',
            'twitter_channel' => '#GertaCup, #Season1'
        ]);

        $this->insert('cup',  [
            'name' => 'GERTA Cup',
            'season' => 'Season 2',
            'twitter_channel' => '#GertaCup, #Season2'
        ]);

        $this->insert('cup',  [
            'name' => 'GERTA Cup',
            'season' => 'Season 3',
            'twitter_channel' => '#GertaCup, #Season3'
        ]);

        /* Bracket Mode Base Netry */
        $this->insert('tournament_bracket_mode',  [
            'name' => 'Single Elimination',
            'description' => 'Normales Single Elimination',
            'twitter_channel' => '#SingleElimination'
        ]);

        $this->insert('tournament_bracket_mode',  [
            'name' => 'Double Elimination',
            'description' => 'Winner Looser Bracket',
            'twitter_channel' => '#DoubleElimination'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('team_participating');
        $this->dropTable('player_participating');
        $this->dropTable('tournament');
        $this->dropTable('tournament_bracket_mode');
        $this->dropTable('cup');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190517_081725_tounament_cup_brackets cannot be reverted.\n";

        return false;
    }
    */
}
