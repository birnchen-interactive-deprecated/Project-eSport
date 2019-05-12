<?php

use yii\db\Migration;

/**
 * Class m190512_161133_base_team_and_subteams
 */
class m190512_161133_base_team_and_subteams extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Main Team
        $this->execute("
         CREATE TABLE IF NOT EXISTS `main_team` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `owner_id` INT NOT NULL,
              `deputy_id` INT NULL,
              `headquater_id` INT NOT NULL,
              `language_id` INT NULL,
              `name` VARCHAR(255) NOT NULL,
              `description` VARCHAR(255) NULL,
              `short_code` VARCHAR(32) NOT NULL,
              `twitter_account` VARCHAR(255) NULL,
              `twitter_channel` VARCHAR(255) NULL,
              `discord_server` VARCHAR(255) NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `id_UNIQUE` (`id` ASC),
              INDEX `FK_MAIN_TEAM_HEADQUATER_ID_idx` (`headquater_id` ASC),
              INDEX `FK_MAIN_TEAM_DEPUTY_ID_idx` (`deputy_id` ASC),
              INDEX `FK_MAIN_TEAM_OWNER_ID_idx` (`owner_id` ASC),
              UNIQUE INDEX `twitter_account_UNIQUE` (`twitter_account` ASC),
              UNIQUE INDEX `twitter_channel_UNIQUE` (`twitter_channel` ASC),
              UNIQUE INDEX `language_id_UNIQUE` (`language_id` ASC),
              UNIQUE INDEX `discord_server_UNIQUE` (`discord_server` ASC),
              CONSTRAINT `FK_MAIN_TEAM_OWNER_ID`
                FOREIGN KEY (`owner_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_MAIN_TEAM_DEPUTY_ID`
                FOREIGN KEY (`deputy_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_MAIN_TEAM_HEADQUATER_ID`
                FOREIGN KEY (`headquater_id`)
                REFERENCES `nationality` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_MAIN_TEAM_LANGUAGE_ID`
                FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // Main Team Member
        $this->execute("
          CREATE TABLE IF NOT EXISTS `main_team_member` (
              `user_id` INT NOT NULL,
              `main_team_id` INT NOT NULL,
              PRIMARY KEY (`main_team_id`, `user_id`),
              INDEX `FK_MAIN_TEAM_MEMBER_USER_ID_idx` (`user_id` ASC),
              CONSTRAINT `FK_MAIN_TEAM_MEMBER_USER_ID`
                FOREIGN KEY (`user_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_MAIN_TEAM_MEMBER_MAIN_TEAM_ID`
                FOREIGN KEY (`main_team_id`)
                REFERENCES `main_team` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // Sub Team
        $this->execute("
          CREATE TABLE IF NOT EXISTS `sub_team` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `main_team_id` INT NOT NULL,
              `game_id` INT NOT NULL,
              `tournament_mode_id` INT NOT NULL,
              `headquater_id` INT NOT NULL,
              `language_id` INT NOT NULL,
              `captain_id` INT NOT NULL,
              `deputy_id` INT NULL,
              `manager_id` INT NULL,
              `trainer_id` INT NULL,
              `name` VARCHAR(255) NOT NULL,
              `short_code` VARCHAR(255) NOT NULL,
              `mixed` TINYINT(4) NOT NULL DEFAULT 0,
              `description` VARCHAR(255) NULL,
              `disqualified` TINYINT(4) NOT NULL DEFAULT 0,
              `twitter_account` VARCHAR(255) NULL,
              `twitter_channel` VARCHAR(255) NULL,
              `discord_server` VARCHAR(255) NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `id_UNIQUE` (`id` ASC),
              UNIQUE INDEX `name_UNIQUE` (`name` ASC),
              UNIQUE INDEX `short_code_UNIQUE` (`short_code` ASC),
              UNIQUE INDEX `twitter_account_UNIQUE` (`twitter_account` ASC),
              UNIQUE INDEX `twitter_channel_UNIQUE` (`twitter_channel` ASC),
              UNIQUE INDEX `discord_server_UNIQUE` (`discord_server` ASC),
              INDEX `FK_MAIN_TEAM_ID_idx` (`main_team_id` ASC),
              INDEX `FK_GAME_ID_idx` (`game_id` ASC),
              INDEX `FK_SUB_TEAM_HEADQUATER_ID_idx` (`headquater_id` ASC),
              INDEX `FK_SUB_TEAMS_LANGUAGE_ID_idx` (`language_id` ASC),
              INDEX `FK_SUB_TEAM_CAPTAIN_ID_idx` (`captain_id` ASC),
              INDEX `FK_SUB_TEAM_DEPUTY_ID_idx` (`deputy_id` ASC),
              INDEX `FK_SUB_TEAMS_MANAGER_ID_idx` (`manager_id` ASC),
              INDEX `FK_SUB_TEAMS_TRAINER_ID_idx` (`trainer_id` ASC),
              INDEX `FK_SUB_TEAM_TOURNAMENT_MODE_ID_idx` (`tournament_mode_id` ASC),
              CONSTRAINT `FK_SUB_TEAM_MAIN_TEAM_ID`
                FOREIGN KEY (`main_team_id`)
                REFERENCES `main_team` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_GAME_ID`
                FOREIGN KEY (`game_id`)
                REFERENCES `games` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_TOURNAMENT_MODE_ID`
                FOREIGN KEY (`tournament_mode_id`)
                REFERENCES `tournament_mode` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_HEADQUATER_ID`
                FOREIGN KEY (`headquater_id`)
                REFERENCES `nationality` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_LANGUAGE_ID`
                FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_CAPTAIN_ID`
                FOREIGN KEY (`captain_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_DEPUTY_ID`
                FOREIGN KEY (`deputy_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_MANAGER_ID`
                FOREIGN KEY (`manager_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_TRAINER_ID`
                FOREIGN KEY (`trainer_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // Sub Team Member
        $this->execute("
          CREATE TABLE IF NOT EXISTS `sub_team_member` (
              `user_id` INT NOT NULL,
              `sub_team_id` INT NOT NULL,
              `is_sub` TINYINT(4) NOT NULL DEFAULT 0,
              PRIMARY KEY (`user_id`, `sub_team_id`),
              INDEX `FK_SUB_TEAM_MEMBER_SUB_TEAM_ID_idx` (`sub_team_id` ASC),
              CONSTRAINT `FK_SUB_TEAM_MEMBER_USER_ID`
                FOREIGN KEY (`user_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_SUB_TEAM_MEMBER_SUB_TEAM_ID`
                FOREIGN KEY (`sub_team_id`)
                REFERENCES `sub_team` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('sub_team_member');
        $this->dropTable('sub_team');
        $this->dropTable('main_team_member');
        $this->dropTable('main_team');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190512_161133_base_team_and_subteams cannot be reverted.\n";

        return false;
    }
    */
}
