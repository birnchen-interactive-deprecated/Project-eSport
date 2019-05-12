<?php

use yii\db\Migration;

/**
 * Class m190425_120035_base_i18n_entrys
 */
class m190425_120035_base_i18n_entrys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* i18n English Translation for Gender */
        $this->insert('gender_i18n',  [
            'id' => '1',
            'language_id' => '2',
            'name' => 'Male'
        ]);

        $this->insert('gender_i18n',  [
            'id' => '2',
            'language_id' => '2',
            'name' => 'Female'
        ]);

        $this->insert('gender_i18n',  [
            'id' => '3',
            'language_id' => '2',
            'name' => 'Miscellaneous'
        ]);

        /* i18n English Translation for Base Languages */
        $this->insert('language_i18n',  [
            'id' => '1',
            'language_id' => '2',
            'name' => 'German'
        ]);

        $this->insert('language_i18n',  [
            'id' => '2',
            'language_id' => '2',
            'name' => 'English'
        ]);

        /* i18n English Translation for Base Nationality */
        $this->insert('nationality_i18n',  [
            'id' => '1',
            'language_id' => '2',
            'name' => 'Germany',
            'synonym_m' => 'German',
            'synonym_w' => 'German',
            'synonym_d' => 'German'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '2',
            'language_id' => '2',
            'name' => 'Austria',
            'synonym_m' => 'Austrian',
            'synonym_w' => 'Austrian',
            'synonym_d' => 'Austrian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '3',
            'language_id' => '2',
            'name' => 'Switzerland',
            'synonym_m' => 'Swiss',
            'synonym_w' => 'Swiss',
            'synonym_d' => 'Swiss'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '4',
            'language_id' => '2',
            'name' => 'France',
            'synonym_m' => 'French',
            'synonym_w' => 'French',
            'synonym_d' => 'French'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '5',
            'language_id' => '2',
            'name' => 'Great Britain',
            'synonym_m' => 'English',
            'synonym_w' => 'English',
            'synonym_d' => 'English'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '6',
            'language_id' => '2',
            'name' => 'Ireland',
            'synonym_m' => 'Irish',
            'synonym_w' => 'Irish',
            'synonym_d' => 'Irish'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '7',
            'language_id' => '2',
            'name' => 'Belgium',
            'synonym_m' => 'Belgian',
            'synonym_w' => 'Belgian',
            'synonym_d' => 'Belgian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '8',
            'language_id' => '2',
            'name' => 'Italy',
            'synonym_m' => 'Italian',
            'synonym_w' => 'Italian',
            'synonym_d' => 'Italian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '9',
            'language_id' => '2',
            'name' => 'Spain',
            'synonym_m' => 'Spanish',
            'synonym_w' => 'Spanish',
            'synonym_d' => 'Spanish'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '10',
            'language_id' => '2',
            'name' => 'Portugal',
            'synonym_m' => 'Portuguese',
            'synonym_w' => 'Portuguese',
            'synonym_d' => 'Portuguese'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '11',
            'language_id' => '2',
            'name' => 'Iceland',
            'synonym_m' => 'Icelandic',
            'synonym_w' => 'Icelandic',
            'synonym_d' => 'Icelandic'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '12',
            'language_id' => '2',
            'name' => 'Norway',
            'synonym_m' => 'Norwegian',
            'synonym_w' => 'Norwegian',
            'synonym_d' => 'Norwegian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '13',
            'language_id' => '2',
            'name' => 'Sweden',
            'synonym_m' => 'Swedish',
            'synonym_w' => 'Swedish',
            'synonym_d' => 'Swedish'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '14',
            'language_id' => '2',
            'name' => 'Finland',
            'synonym_m' => 'Finnish',
            'synonym_w' => 'Finnish',
            'synonym_d' => 'Finnish'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '15',
            'language_id' => '2',
            'name' => 'Denmark',
            'synonym_m' => 'Danish',
            'synonym_w' => 'Danish',
            'synonym_d' => 'Danish'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '16',
            'language_id' => '2',
            'name' => 'Estonia',
            'synonym_m' => 'Estonian',
            'synonym_w' => 'Estonian',
            'synonym_d' => 'Estonian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '17',
            'language_id' => '2',
            'name' => 'Latvia',
            'synonym_m' => 'Latvian',
            'synonym_w' => 'Latvian',
            'synonym_d' => 'Latvian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '18',
            'language_id' => '2',
            'name' => 'Lithuania',
            'synonym_m' => 'Lithuanian',
            'synonym_w' => 'Lithuanian',
            'synonym_d' => 'Lithuanian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '19',
            'language_id' => '2',
            'name' => 'Poland',
            'synonym_m' => 'Polish',
            'synonym_w' => 'Polish',
            'synonym_d' => 'Polish'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '20',
            'language_id' => '2',
            'name' => 'Belarus',
            'synonym_m' => 'Belarusian',
            'synonym_w' => 'Belarusian',
            'synonym_d' => 'Belarusian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '21',
            'language_id' => '2',
            'name' => 'Netherlands',
            'synonym_m' => 'Dutch',
            'synonym_w' => 'Dutch',
            'synonym_d' => 'Dutch'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '22',
            'language_id' => '2',
            'name' => 'Ukraine',
            'synonym_m' => 'Ukrainian',
            'synonym_w' => 'Ukrainian',
            'synonym_d' => 'Ukrainian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '23',
            'language_id' => '2',
            'name' => 'Czech Republic',
            'synonym_m' => 'Czech',
            'synonym_w' => 'Czech',
            'synonym_d' => 'Czech'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '24',
            'language_id' => '2',
            'name' => 'Slovak Republic',
            'synonym_m' => 'Slovak',
            'synonym_w' => 'Slovak',
            'synonym_d' => 'Slovak'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '25',
            'language_id' => '2',
            'name' => 'Hungary',
            'synonym_m' => 'Hungarian',
            'synonym_w' => 'Hungarian',
            'synonym_d' => 'Hungarian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '26',
            'language_id' => '2',
            'name' => 'Romania',
            'synonym_m' => 'Romanian',
            'synonym_w' => 'Romanian',
            'synonym_d' => 'Romanian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '27',
            'language_id' => '2',
            'name' => 'Bulgaria',
            'synonym_m' => 'Bulgarian',
            'synonym_w' => 'Bulgarian',
            'synonym_d' => 'Bulgarian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '28',
            'language_id' => '2',
            'name' => 'Croatia',
            'synonym_m' => 'Croatian',
            'synonym_w' => 'Croatian',
            'synonym_d' => 'Croatian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '29',
            'language_id' => '2',
            'name' => 'Bosnia and Herzegovina',
            'synonym_m' => 'Bosnian',
            'synonym_w' => 'Bosnian',
            'synonym_d' => 'Bosnian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '30',
            'language_id' => '2',
            'name' => 'Serbia',
            'synonym_m' => 'Serbian',
            'synonym_w' => 'Serbian',
            'synonym_d' => 'Serbian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '31',
            'language_id' => '2',
            'name' => 'Albania',
            'synonym_m' => 'Albanian',
            'synonym_w' => 'Albanian',
            'synonym_d' => 'Albanian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '32',
            'language_id' => '2',
            'name' => 'Greece',
            'synonym_m' => 'Greek',
            'synonym_w' => 'Greek',
            'synonym_d' => 'Greek'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '33',
            'language_id' => '2',
            'name' => 'Moldova',
            'synonym_m' => 'Moldovan',
            'synonym_w' => 'Moldovan',
            'synonym_d' => 'Moldovan'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '34',
            'language_id' => '2',
            'name' => 'Georgia',
            'synonym_m' => 'Georgian',
            'synonym_w' => 'Georgian',
            'synonym_d' => 'Georgian'
        ]);

        $this->insert('nationality_i18n',  [
            'id' => '35',
            'language_id' => '2',
            'name' => 'Monaco',
            'synonym_m' => 'Monegasque',
            'synonym_w' => 'Monegasque',
            'synonym_d' => 'Monegasque'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // reset nationality i18n table
        $this->dropTable('nationality_i18n');
        $this->execute("
            CREATE TABLE IF NOT EXISTS `nationality_i18n` (
              `id` INT NOT NULL,
              `language_id` INT NOT NULL,
              `name` VARCHAR(255) NOT NULL,
              `synonym_m` VARCHAR(255) NOT NULL,
              `synonym_w` VARCHAR(255) NOT NULL,
              `synonym_d` VARCHAR(45) NULL,
              PRIMARY KEY (`id`, `language_id`),
              INDEX `FK_NATIONALITY_I18N_LANGUAGE_ID_idx` (`language_id` ASC),
              CONSTRAINT `FK_NATIONALITY_I18N_ID`
                FOREIGN KEY (`id`)
                REFERENCES `nationality` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_NATIONALITY_I18N_LANGUAGE_ID`
                FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // reset language i18n table
        $this->dropTable('language_i18n');
        $this->execute("
            CREATE TABLE IF NOT EXISTS `language_i18n` (
              `id` INT NOT NULL,
              `language_id` INT NOT NULL,
              `name` VARCHAR(45) NOT NULL,
              PRIMARY KEY (`id`, `language_id`),
              INDEX `FK_LANGUAGE_I18N_Language_ID_idx` (`language_id` ASC),
              CONSTRAINT `FK_LANGUAGE_I18N_ID`
                FOREIGN KEY (`id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_LANGUAGE_I18N_Language_ID`
                FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");

        // reset gender i18n table
        $this->dropTable('gender_i18n');
        $this->execute("
            CREATE TABLE IF NOT EXISTS `gender_i18n` (
              `id` INT NOT NULL,
              `language_id` INT NOT NULL,
              `name` VARCHAR(45) NOT NULL,
              PRIMARY KEY (`id`, `language_id`),
              INDEX `FK_GENDER_I18N_LANGUAGE_ID_idx` (`language_id` ASC),
              CONSTRAINT `FK_GENDER_I18N_ID`
                FOREIGN KEY (`id`)
                REFERENCES `gender` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
              CONSTRAINT `FK_GENDER_I18N_LANGUAGE_ID`
                FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            ENGINE = InnoDB");
    }
}
