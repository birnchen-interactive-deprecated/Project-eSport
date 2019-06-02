<?php

use yii\db\Migration;

/**
 * Class m190602_162847_backet_encounter_and_points
 */
class m190602_162847_backet_encounter_and_points extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Rules Set
        $this->execute("
            CREATE TABLE IF NOT EXISTS `tournament_encounter` (
              `bracket_id` INT NOT NULL,
              `tournament_id` INT NOT NULL,
              PRIMARY KEY (`bracket_id`, `tournament_id`))
            ENGINE = InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tournament_encounter');
    }
}