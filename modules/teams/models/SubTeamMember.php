<?php

namespace app\modules\teams\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

use app\modules\user\models\User;
use app\modules\user\models\SubTeam;

/**
 * Class main_team_member
 * @package app\modules\teams\models
 *
 * @property int $user_id
 * @property int $sub_team_id
 * @property bool $is_sub
 */
class SubTeamMember extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'sub_team_member';
    }

    /**
     * @return int user id
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
     * @return int sub team id
     */
    public function getSubTeamId()
    {
        return $this->sub_team_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getSubTeam()
    {
        return $this->hasOne(SubTeam::className(), ['id' => 'sub_team_id']);
    }

    /**
     * @return int user is substitude
     */
    public function getIsSub()
    {
        return $this->is_sub;
    }

    /**
     * @param $mainTeamId
     * @return MainTeamMember[]
     */
    public static function getSubTeamMembers($subTeamId)
    {
        return static::findAll(['sub_team_id' => $subTeamId]);
    }

    /**
     * @param $subTeamId
     * @return SubTeamMember[]
     */
    public static function getTeamMembers($subTeamId)
    {
        return static::findAll(['sub_team_id' => $subTeamId]);
    }
}