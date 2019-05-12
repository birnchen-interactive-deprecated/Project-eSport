<?php

namespace app\modules\tournaments\models;

use yii\db\ActiveRecord;

/**
 * Class Gender
 * @package app\modules\tournaments\models
 *
 * @property int $id
 * @property int $game_id
 * @property string $name
 * @property string $description
 * @property int $max_player
 * @property int $sub_player
 * @property string $twitter_channel
 */
class TournamentMode extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'tournament_mode';
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
     * @return ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
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
	 * @return int id
	 */
	public function getMaxPlayer()
	{
		return $this->max_player;
	}

	/**
	 * @return int id
	 */
	public function getSubPlayer()
	{
		return $this->sub_player;
	}

	/**
	 * @return string name
	 */
	public function getTwitterChannel()
	{
		return $this->twitter_channel;
	}
}