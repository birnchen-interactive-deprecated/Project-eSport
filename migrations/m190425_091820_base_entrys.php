<?php

use yii\db\Migration;
use yii\db\Expression;

/**
 * Class m190425_091820_base_entrys
 */
class m190425_091820_base_entrys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Gender base as standard German */
        $this->insert('gender',  [
            'name' => 'Männlich'
        ]);

        $this->insert('gender',  [
            'name' => 'Weiblich'
        ]);

        $this->insert('gender',  [
            'name' => 'Divers'
        ]);

        /* Base languages English and German as standard German */
        $this->insert('language',  [
            'name' => 'Deutsch',
            'locale' => 'de-DE'
        ]);

        $this->insert('language',  [
            'name' => 'Englisch',
            'locale' => 'en-US'        ]);

        /* Base Nationality as standard German */
        $this->insert('nationality',  [
            'name' => 'Deutschland',
            'synonym_m' => 'Deutscher',
            'synonym_w' => 'Deutsche',
            'synonym_d' => 'Deutsches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Österreich',
            'synonym_m' => 'Österreichischer',
            'synonym_w' => 'Österreichische',
            'synonym_d' => 'Österreichisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Schweiz',
            'synonym_m' => 'Schweizer',
            'synonym_w' => 'Schweizer',
            'synonym_d' => 'Schweizer'
        ]);

        $this->insert('nationality',  [
            'name' => 'Frankreich',
            'synonym_m' => 'Französischer',
            'synonym_w' => 'Französische',
            'synonym_d' => 'Französisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Großbritannien',
            'synonym_m' => 'Englischer',
            'synonym_w' => 'Englische',
            'synonym_d' => 'Englisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Irland',
            'synonym_m' => 'Irländischer',
            'synonym_w' => 'Irländische',
            'synonym_d' => 'Irländisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Belgien',
            'synonym_m' => 'Belgischer',
            'synonym_w' => 'Belgische',
            'synonym_d' => 'Belgisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Italien',
            'synonym_m' => 'Italienischer',
            'synonym_w' => 'Italienische',
            'synonym_d' => 'Italienisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Spanien',
            'synonym_m' => 'Spanischer',
            'synonym_w' => 'Spanische',
            'synonym_d' => 'Spanisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Portugal',
            'synonym_m' => 'Portugiesischer',
            'synonym_w' => 'Portugiesische',
            'synonym_d' => 'Portugiesisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Island',
            'synonym_m' => 'Isländischer',
            'synonym_w' => 'Isländische',
            'synonym_d' => 'Isländisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Norwegen',
            'synonym_m' => 'Norwegischer',
            'synonym_w' => 'Norwegische',
            'synonym_d' => 'Norwegisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Schweden',
            'synonym_m' => 'Schwedischer',
            'synonym_w' => 'Schwedische',
            'synonym_d' => 'Schwedisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Finnland',
            'synonym_m' => 'Finnischer',
            'synonym_w' => 'Finnische',
            'synonym_d' => 'Finnisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Dänemark',
            'synonym_m' => 'Dänischer',
            'synonym_w' => 'Dänische',
            'synonym_d' => 'Dänisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Estland',
            'synonym_m' => 'Estländischer',
            'synonym_w' => 'Estländische',
            'synonym_d' => 'Estländisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Lettland',
            'synonym_m' => 'Lettischer',
            'synonym_w' => 'Lettische',
            'synonym_d' => 'Lettisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Litauen',
            'synonym_m' => 'Litischer',
            'synonym_w' => 'Litische',
            'synonym_d' => 'Litisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Polen',
            'synonym_m' => 'Polnischer',
            'synonym_w' => 'Polnische',
            'synonym_d' => 'Polnisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Weißrussland',
            'synonym_m' => 'Weißrussischer',
            'synonym_w' => 'Weißrussische',
            'synonym_d' => 'Weißrussisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Niederlande',
            'synonym_m' => 'Niederländischer',
            'synonym_w' => 'Niederländische',
            'synonym_d' => 'Niederländisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Ukraine',
            'synonym_m' => 'Ukrainischer',
            'synonym_w' => 'Ukrainische',
            'synonym_d' => 'Ukrainisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Tschechische Republik',
            'synonym_m' => 'Tschechischer',
            'synonym_w' => 'Tschechische',
            'synonym_d' => 'Tschechisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Slowakische Republik',
            'synonym_m' => 'Slowakischer',
            'synonym_w' => 'Slowakische',
            'synonym_d' => 'Slowakisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Ungarn',
            'synonym_m' => 'Ungarischer',
            'synonym_w' => 'Ungarische',
            'synonym_d' => 'Ungarisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Rumänien',
            'synonym_m' => 'Rumänischer',
            'synonym_w' => 'Rumänische',
            'synonym_d' => 'Rumänisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Bulgarien',
            'synonym_m' => 'Bulgarischer',
            'synonym_w' => 'Bulgarische',
            'synonym_d' => 'Bulgarisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Kroatien',
            'synonym_m' => 'Kroatischer',
            'synonym_w' => 'Kroatische',
            'synonym_d' => 'Kroatisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Bosnien und Herzegowina',
            'synonym_m' => 'Bosnischer',
            'synonym_w' => 'Bosnische',
            'synonym_d' => 'Bosnisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Serbien',
            'synonym_m' => 'Serbischer',
            'synonym_w' => 'Serbische',
            'synonym_d' => 'Serbisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Albanien',
            'synonym_m' => 'Albanischre',
            'synonym_w' => 'Albanische',
            'synonym_d' => 'Albanisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Griechenland',
            'synonym_m' => 'Griechischer',
            'synonym_w' => 'Griechische',
            'synonym_d' => 'Griechisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Moldova',
            'synonym_m' => 'Moldawischer',
            'synonym_w' => 'Moldawische',
            'synonym_d' => 'Moldawisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Georgien',
            'synonym_m' => 'Georgischer',
            'synonym_w' => 'Georgische',
            'synonym_d' => 'Georgisches'
        ]);

        $this->insert('nationality',  [
            'name' => 'Monaco',
            'synonym_m' => 'Monegassischer',
            'synonym_w' => 'Monegassische',
            'synonym_d' => 'Monegassisches'
        ]);

        /* Base user 'Admin' */
        /*$this->insert('user', [
            'language_id' => '1',
            'gender_id' => '1',
            'nationality_id' => '1',
            'dt_created' => new Expression('NOW()'),
            'dt_updated' => new Expression('NOW()'),
            'username' => 'admin',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('Birnchen2016'),
            'email' => 'admin@project-esport.gg',
            'birthday' => '0000-00-00'
            //AdminPW123!.
        ]);*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // resett user table
        $this->dropTable('user');
        $this->execute("
          CREATE TABLE IF NOT EXISTS `user` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `birthday` DATE NOT NULL,
            `gender_id` INT NOT NULL,
            `language_id` INT NOT NULL,
            `nationality_id` INT NOT NULL,
            `pre_name` VARCHAR(255) NULL,
            `last_name` VARCHAR(255) NULL,
            `zip_code` VARCHAR(255) NULL,
            `city` VARCHAR(255) NULL,
            `street` VARCHAR(255) NULL,
            `dt_created` DATETIME NOT NULL,
            `dt_updated` DATETIME NOT NULL,
            `is_password_change_required` TINYINT(4) NULL DEFAULT 0,
            `access_token` VARCHAR(255) NOT NULL,
            `auth_key` VARCHAR(255) NOT NULL,
            `twitter_account` VARCHAR(255) NULL,
            `twitter_channel` VARCHAR(255) NULL,
            `discord_id` VARCHAR(255) NULL,
            `discord_server` VARCHAR(255) NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `user_id_UNIQUE` (`id` ASC),
            UNIQUE INDEX `username_UNIQUE` (`username` ASC),
            UNIQUE INDEX `email_UNIQUE` (`email` ASC),
            INDEX `FK_USER_GENDER_ID_idx` (`gender_id` ASC),
            INDEX `FK_USER_LANGUAGE_ID_idx` (`language_id` ASC),
            INDEX `FK_USER_NATIONALITY_ID_idx` (`nationality_id` ASC),
            UNIQUE INDEX `twitter_account_UNIQUE` (`twitter_account` ASC),
            UNIQUE INDEX `twitter_channel_UNIQUE` (`twitter_channel` ASC),
            UNIQUE INDEX `Discord_id_UNIQUE` (`Discord_id` ASC),
            UNIQUE INDEX `Discord_Server_UNIQUE` (`Discord_Server` ASC),
            CONSTRAINT `FK_USER_GENDER_ID`
              FOREIGN KEY (`gender_id`)
              REFERENCES `gender` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `FK_USER_LANGUAGE_ID`
              FOREIGN KEY (`language_id`)
              REFERENCES `language` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `FK_USER_NATIONALITY_ID`
              FOREIGN KEY (`nationality_id`)
              REFERENCES `nationality` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE)
          ENGINE = InnoDB");

        // reset gender table
        $this->dropForeignKey(
            'FK_USER_GENDER_ID',
            'user'
        );
        $this->dropTable('gender');
        $this->execute("
          CREATE TABLE IF NOT EXISTS `gender` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            UNIQUE INDEX `gender_id_UNIQUE` (`id` ASC),
            PRIMARY KEY (`id`))
          ENGINE = InnoDB");
        $this->addForeignKey(
            'FK_USER_GENDER_ID',
            'user',
            'gender_id',
            'gender',
            'id',
            'CASCADE'
        );

        // reset language table
        $this->dropForeignKey(
            'FK_USER_LANGUAGE_ID',
            'user'
        );
        $this->dropTable('language');
        $this->execute("
          CREATE TABLE IF NOT EXISTS `language` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            `locale` VARCHAR(45) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `language_id_UNIQUE` (`id` ASC))
          ENGINE = InnoDB");
        $this->addForeignKey(
            'FK_USER_LANGUAGE_ID',
            'user',
            'language_id',
            'language',
            'id',
            'CASCADE'
        );

        // reset nationality table
        $this->dropForeignKey(
            'FK_USER_NATIONALITY_ID',
            'user'
        );
        $this->dropTable('nationality');
        $this->execute("
          CREATE TABLE IF NOT EXISTS `nationality` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `synonym_m` VARCHAR(255) NOT NULL,
            `synonym_w` VARCHAR(255) NOT NULL,
            `synonym_d` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `nationality_id_UNIQUE` (`id` ASC),
            UNIQUE INDEX `name_UNIQUE` (`name` ASC))
          ENGINE = InnoDB");
        $this->addForeignKey(
            'FK_USER_NATIONALITY_ID',
            'user',
            'nationality_id',
            'nationality',
            'id',
            'CASCADE'
        );
    }
}
