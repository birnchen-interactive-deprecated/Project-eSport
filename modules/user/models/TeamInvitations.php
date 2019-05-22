<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;

use app\modules\teams\models\MainTeam;

use app\modules\user\models\User;

/**
 * Class Gender
 * @package app\modules\user\models
 *
 * @property int $user_id
 * @property int $main_team_id
 * @property bool $rejected
 */
class TeamInvitations extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'team_invitations';
    }

	/**
	 * @return int id
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

	/**
	 * @return string name
	 */
	public function getMainTeamId()
	{
		return $this->main_team_id;
	}

	/**
     * @return ActiveQuery
     */
    public function getMainTeam()
    {
        return $this->hasOne(MainTeam::className(), ['id' => 'main_team_id']);
    }

	/**
	 * @return string name
	 */
	public function getRejected()
	{
		return $this->rejected;
	}

	/**
     * @return ActiveQuery
     */
    public function getInvitations()
    {
        return $this->hasMany(MainTeamMember::className(), ['main_team_id' => 'id']);
    }
}