<?php

namespace app\modules\teams\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

use app\modules\user\models\User;
use app\modules\user\models\Nationality;
use app\modules\user\models\Language;

use app\modules\teams\models\MainTeamMember;

/**
 * Class MainTeam
 * @package app\modules\teams\models
 *
 * @property int $id
 * @property int $owner_id
 * @property int $deputy_id
 * @property int $headquater_id
 * @property int $language_id
 * @property string $name
 * @property string $description
 * @property string $short_code
 * @property string $twitter_account
 * @property string $twitter_channel
 * @property string $discord_server
 */
 class MainTeam extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'main_team';
    }

    /**
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return int owner id
	 */
	public function getOwnerId()
	{
		return $this->owner_id;
	}

	/**
     * @return ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

	/**
	 * @return int deputy id
	 */
	public function getDeputyId()
	{
		return $this->deputy_id;
	}

	/**
     * @return ActiveQuery
     */
    public function getDeputy()
    {
        return $this->hasOne(User::className(), ['id' => 'deputy_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamMember()
    {
        return $this->hasMany(MainTeamMember::className(), ['main_team_id' => 'id']);
    }

	/**
	 * @return int Headquater id
	 */
    public function getHeadquaterId()
    {
        return $this->headquater_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getHeadquarter()
    {
        return $this->hasOne(Nationality::className(), ['id' => 'headquarter_id']);
    }

	/**
	 * @return int Language id
	 */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
	 * @return string name
	 */
    public function getName()
    {
        return $this->name;
    }

    /**
	 * @return string description
	 */
    public function getTeamDescription()
    {
        return $this->description;
    }

    /**
	 * @return string Short Code
	 */
    public function getShortCode()
    {
        return $this->short_code;
    }

    /**
     * @return ActiveQuery
     */
    /*public function getSubTeams() {
        return $this->hasMany(SubTeam::className(), ['main_team_id' => 'team_id']);
    }*/

    /**
     * @return ActiveQuery
     */
    public function getSubTeamsGroupByTournamentMode($sort = true)
    {
       
        $subTeams = $this->hasMany(SubTeam::className(), ['main_team_id' => 'id'])->orderBy('tournament_mode_id')->all();
    
        $subTeamsGrouped = [];
        foreach ($subTeams as $subTeamKey => $subTeam) {
            $tournamentModeName = $subTeam->getTournamentMode()->one()->getName();
    
           $subTeamsGrouped[$tournamentModeName][] = $subTeam;
        }
    
        if ($sort) {
            foreach ($subTeamsGrouped as $subTeamKey => $subTeams) {
                usort($subTeamsGrouped[$subTeamKey], function($a, $b) {
                    return $a->getTeamName() > $b->getTeamName();
                });
            }
        }
    
        return $subTeamsGrouped;
    }

    /**
     * @return array
     */
    public function getTeamMemberWithOwner($sort = true)
    {
        $members = [];
        $members[] = $this->hasOne(User::className(), ['id' => 'owner_id'])->one();
        foreach ($this->getTeamMember()->all() as $teamMemberKey => $teamMember) {
            $members[] = $teamMember->getUser()->one();
        }

        if ($sort) {
            usort($members, function($a, $b) {
                return $a->getUsername() > $b->getUsername();
            });
        }

        return $members;
    }

    /**
	 * @return string Twitter Account
	 */
    public function getTwitterAccount()
    {
        return $this->twitter_account;
    }

    /**
	 * @return string Twitter Channel
	 */
    public function getTwitterChannel()
    {
        return $this->twitter_channel;
    }

    /**
	 * @return string Discord Server
	 */
    public function getDiscordServer()
    {
        return $this->discord_server;
    }

}