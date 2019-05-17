<?php

namespace app\modules\tournaments\models;

use yii\db\ActiveRecord;

/**
 * Class TeamParticipating
 * @package app\modules\tournament\models
 *
 * @property int $sub_Team_id
 * @property int $tournament_id
 * @property bool $checked_in
 */
class TeamParticipating extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'team_participating';
    }

	/**
	 * @return int id
	 */
	public function getSubTeamId()
	{
		return $this->sub_Team_id;
	}

	/**
	 * @return string name
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