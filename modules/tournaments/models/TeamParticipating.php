<?php

namespace app\modules\tournaments\models;

use yii\db\ActiveRecord;

/**
 * Class TeamParticipating
 * @package app\modules\tournament\models
 *
 * @property int $sub_team_id
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
		return $this->sub_team_id;
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

    /**
     * @param $tournamentId
     * @param $subTeam
     * @return TeamParticipating|null
     */
    public static function findTeamParticipating($tournamentId, $subTeam)
    {
        return static::findOne(['tournament_id' => $tournamentId, 'sub_team_id' => $subTeam]);
    }

    /**
     * @param $tournamentId
     * @param $subTeam
     * @return TeamParticipating|null
     */
    public static function findTeamCheckedIn($tournamentId, $subTeam)
    {
        return static::findOne(['tournament_id' => $tournamentId, 'sub_team_id' => $subTeam, 'checked_in' => 1]);
    }
}