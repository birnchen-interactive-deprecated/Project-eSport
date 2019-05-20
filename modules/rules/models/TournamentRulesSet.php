<?php

namespace app\modules\rules\models;

use yii\db\ActiveRecord;

/**
 * Class Gender
 * @package app\modules\rules\models
 *
 * @property int $id
 * @property int $game_id
 * @property string $name
 */
class TournamentRulesSet extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'tournament_rules_set';
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
	public function getGameId()
	{
		return $this->game_id;
	}

	/**
	 * @return string name
	 */
	public function getName()
	{
		return $this->name;
	}
}