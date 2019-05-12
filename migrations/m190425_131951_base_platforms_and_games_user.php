<?php

use yii\db\Migration;

/**
 * Class m190425_131951_base_platforms_and_games_user
 */
class m190425_131951_base_platforms_and_games_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // User Games
        $this->execute("
          CREATE TABLE IF NOT EXISTS `user_games` (
            `game_id` INT NOT NULL,
            `user_id` INT NOT NULL,
            `platform_id` INT NOT NULL,
            `player_id` VARCHAR(255) NOT NULL,
            `visible` TINYINT(4) NOT NULL DEFAULT 0,
            PRIMARY KEY (`game_id`, `user_id`, `platform_id`),
            
            INDEX `FK_USER_GAME_USER_ID_idx` (`user_id` ASC),
            UNIQUE INDEX `player_id_UNIQUE` (`player_id` ASC),
            INDEX `FK_USER_PLATFORM_ID_idx` (`platform_id` ASC),
            CONSTRAINT `FK_USER_GAME_USER_ID`
              FOREIGN KEY (`user_id`)
              REFERENCES `user` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `FK_USER_GAME_PLATFORM_ID`
              FOREIGN KEY (`platform_id`)
              REFERENCES `platforms` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `FK_USER_GAME_GAME_ID`
              FOREIGN KEY (`game_id`)
              REFERENCES `games` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE)
          ENGINE = InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_USER_GAME_GAME_ID',
            'user_games'
        );

        $this->dropForeignKey(
            'FK_USER_GAME_USER_ID',
            'user_games'
        );

        $this->dropForeignKey(
            'FK_USER_GAME_PLATFORM_ID',
            'user_games'
        );

        $this->dropTable('user_games');
    }
}
