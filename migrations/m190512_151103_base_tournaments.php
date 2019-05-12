<?php

use yii\db\Migration;

/**
 * Class m190512_151103_base_team_and_subteams
 */
class m190512_151103_base_tournaments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Main Teams
        $this->execute("
          CREATE TABLE IF NOT EXISTS `tournament_mode` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `game_id` INT NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            `description` VARCHAR(255) NOT NULL,
            `max_player` INT(11) NOT NULL,
            `sub_player` INT(11) NOT NULL,
            `twitter_channel` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`, `game_id`),
            UNIQUE INDEX `id_UNIQUE` (`id` ASC),
            INDEX `FK_TOURNAMENT_MODE_GAME_ID_idx` (`game_id` ASC),
            CONSTRAINT `FK_TOURNAMENT_MODE_GAME_ID`
              FOREIGN KEY (`game_id`)
              REFERENCES `games` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE)
          ENGINE = InnoDB");

        /* Tournament Mode Base German */
        $this->insert('tournament_mode',  [
            'game_id' => '1',
            'name' => '2v2',
            'description' => '2v2 Team mit zwei Leuten gegen Team mit zwei Leuten',
            'max_player' => '3',
            'sub_player' => '1',
            'twitter_channel' =>'#2v2'
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropTable('tournament_mode');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190512_151103_base_team_and_subteams cannot be reverted.\n";

        return false;
    }
    */
}
