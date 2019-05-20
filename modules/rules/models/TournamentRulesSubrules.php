<?php

namespace app\modules\rules\models;

use yii\db\ActiveRecord;

/**
 * Class Gender
 * @package app\modules\rules\models
 *
 * @property int $id
 * @property int $rules_set_id
 * @property int $paragraph
 * @property string $name
 * @property string $description
 */
class TournamentRulesSubrules extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'tournament_rules_subrules';
    }

	/**
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return int id
	 */
	public function getRulesSetId()
	{
		return $this->rules_set_id;
	}

	/**
	 * @return int id
	 */
	public function getParagraph()
	{
		return $this->paragraph;
	}

	/**
	 * @return string name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string name
	 */
	public function getDescription()
	{
		return $this->description;
	}
}