<?php

use yii\db\Migration;

/**
 * Class m190520_062007_rules_set_and_rules
 */
class m190520_062007_rules_set_and_rules extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Rules Set
        $this->execute("
          CREATE TABLE IF NOT EXISTS `tournament_rules_set` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `game_id` INT NOT NULL,
              `name` VARCHAR(255) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `id_UNIQUE` (`id` ASC))
            ENGINE = InnoDB");

        // Rules
        $this->execute("
          CREATE TABLE IF NOT EXISTS `tournament_rules_subrules` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `rules_set_id` INT NOT NULL,
              `paragraph` INT NOT NULL,
              `name` VARCHAR(255) NOT NULL,
              `description` VARCHAR(255) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `id_UNIQUE` (`id` ASC),
              INDEX `FK_TOURNAMENT_RULES_SUBRULES_RULES_ID_idx` (`rules_set_id` ASC),
              CONSTRAINT `FK_TOURNAMENT_RULES_SUBRULES_RULES_ID`
                FOREIGN KEY (`rules_set_id`)
                REFERENCES `tournament_rules_set` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        $this->insert('tournament_rules_set',  [
            'game_id' => '1',
            'name' => 'Gerta Cup Rules'
        ]);

        // add foreign key for table `user`
        $this->addForeignKey(
            'FK_TOURNAMENT_RULES_ID_TOURNAMENT_RULES_RULES_SET_ID',
            'tournament',
            'rules_id',
            'tournament_rules_set',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_TOURNAMENT_RULES_ID_TOURNAMENT_RULES_RULES_SET_ID',
            'tournament'
        );

        $this->dropTable('tournament_rules_subrules');
        $this->dropTable('tournament_rules_set');
    }
}