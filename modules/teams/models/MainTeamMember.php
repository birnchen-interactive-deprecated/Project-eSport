<?php

namespace app\modules\teams\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

use app\modules\user\models\User;
use app\modules\user\models\MainTeam;

/**
 * Class main_team_member
 * @package app\modules\teams\models
 *
 * @property int $user_id
 * @property int $main_team_id
 */
class MainTeamMember extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'main_team_member';
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
     * @return int main team id
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
     * @param $mainTeamId
     * @return MainTeamMember[]
     */
    public static function getTeamMembers($mainTeamId)
    {
        return static::findAll(['main_team_id' => $mainTeamId]);
    }
}