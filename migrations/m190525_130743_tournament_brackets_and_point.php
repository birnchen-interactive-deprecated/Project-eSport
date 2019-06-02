<?php

use yii\db\Migration;

/**
 * Class m190525_130743_tournament_brackets_and_point
 */
class m190525_130743_tournament_brackets_and_point extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Rules Set
        $this->execute("
          CREATE TABLE IF NOT EXISTS `tournament_bracket` (
          `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `encounter_id` INT(11) NULL,
          `tournament_id` INT(11) NOT NULL,
          `best_of` INT(11) NOT NULL,
          `tournament_round` INT(11) NOT NULL,
          `live_stream` INT(11) NOT NULL DEFAULT 0,
          `is_winner_bracket` INT(11) NOT NULL,
          `team_1_id` INT(11) NULL,
          `team_2_id` INT(11) NULL,
          `user_1_id` INT(11) NULL,
          `user_2_id` INT(11) NULL,
          `winner_bracket` BIGINT(20) NULL,
          `looser_bracket` BIGINT(20) NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `idtournament_bracket_UNIQUE` (`id` ASC),
          INDEX `FK_TOURNAMENT_BRACKET_TOURNAMENT_ID_idx` (`tournament_id` ASC),
          INDEX `FK_TOURNAMENT_BRACKET_TEAM_1_ID_idx` (`team_1_id` ASC),
          INDEX `FK_TOURNAMENT_BRACKET_TEAM_2_ID_idx` (`team_2_id` ASC),
          INDEX `FK_TOURNAMENT_USER_1_ID_idx` (`user_1_id` ASC),
          INDEX `FK_TOURNAMENT_USER_2_ID_idx` (`user_2_id` ASC),
          CONSTRAINT `FK_TOURNAMENT_BRACKET_TOURNAMENT_ID`
            FOREIGN KEY (`tournament_id`)
            REFERENCES `tournament` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
          CONSTRAINT `FK_TOURNAMENT_BRACKET_TEAM_1_ID`
            FOREIGN KEY (`team_1_id`)
            REFERENCES `sub_team` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
          CONSTRAINT `FK_TOURNAMENT_BRACKET_TEAM_2_ID`
            FOREIGN KEY (`team_2_id`)
            REFERENCES `sub_team` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
          CONSTRAINT `FK_TOURNAMENT_USER_1_ID`
            FOREIGN KEY (`user_1_id`)
            REFERENCES `user` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
          CONSTRAINT `FK_TOURNAMENT_USER_2_ID`
            FOREIGN KEY (`user_2_id`)
            REFERENCES `user` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE)
        ENGINE = InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tournament_bracket');
    }
}