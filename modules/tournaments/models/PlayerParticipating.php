<?php

namespace app\modules\tournaments\models;

use yii\db\ActiveRecord;

/**
 * Class PlayerParticipating
 * @package app\modules\tournament\models
 *
 * @property int $user_id
 * @property int $tournament_id
 * @property bool $checked_in
 */
class PlayerParticipating extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'player_participating';
    }

	/**
	 * @return int id
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * @return string id
	 */
	public function getTournamentId()
	{
		return $this->tournament_id;
	}

	/**
	 * @return bool checked in
	 */
	public function getIsCheckedin()
	{
		return $this->checked_in;
	}
}