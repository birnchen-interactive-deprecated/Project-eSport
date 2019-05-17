<?php

namespace app\modules\tournaments\models;

use yii\db\ActiveRecord;

/**
 * Class GCup
 * @package app\modules\tournament\models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $twitter_channel
 */
class TournamentBracketMode extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'tournament_bracket_mode';
    }

	/**
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
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

	/**
	 * @return string name
	 */
	public function getTwitterChannel()
	{
		return $this->twitter_channel;
	}
}