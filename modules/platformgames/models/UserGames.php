<?php

namespace app\modules\platformgames\models;

use yii\db\ActiveRecord;

/**
 * Class Gender
 * @package app\modules\platformgames\models
 *
 * @property int $game_id
 * @property int $user_id
 * @property int $platform_id
 * @property string $player_id
 * @property bool $visible
 */
class UserGames extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'user_games';
    }

	/**
	 * @return int game id
	 */
	public function getGameId()
	{
		return $this->game_id;
	}

	/**
	 * @return int user id
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * @return int platform id
	 */
	public function getPlatformId()
	{
		return $this->platform_id;
	}

	/**
	 * @return int platform id
	 */
	public function getPlatform()
	{
		return $this->platform_id;
	}

	/**
	 * @return string player id
	 */
	public function getPlayerId()
	{
		return $this->player_id;
	}

	/**
	 * @return bool visible
	 */
	public function getIsVisible()
	{
		return $this->visible;
	}

	//public function save()
    //{
        //if (!$this->player_id) $this->player_id = uniqid();
        //data::set($this->game_id, $this->data);
        //$this->saved = true;
        //return true;
    //}
}