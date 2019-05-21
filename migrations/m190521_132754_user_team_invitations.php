<?php

use yii\db\Migration;

/**
 * Class m190521_132754_user_team_invitations
 */
class m190521_132754_user_team_invitations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Rules Set
        $this->execute("
          CREATE TABLE IF NOT EXISTS `team_invitations` (
              `user_id` INT NOT NULL,
              `main_team_id` INT NOT NULL,
              `rejected` TINYINT(4) NOT NULL DEFAULT 0,
              PRIMARY KEY (`user_id`, `main_team_id`),
              INDEX `FK_USER_TEAM_INVITATIONS_MAIN_TEAM_ID_idx` (`main_team_id` ASC),
              CONSTRAINT `FK_TEAM_INVITATIONS_USER_ID`
                FOREIGN KEY (`user_id`)
                REFERENCES `user` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_USER_TEAM_INVITATIONS_MAIN_TEAM_ID`
                FOREIGN KEY (`main_team_id`)
                REFERENCES `main_team` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('team_invitations');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190521_132754_user_team_invitations cannot be reverted.\n";

        return false;
    }
    */
}
