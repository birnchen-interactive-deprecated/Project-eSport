<?php

namespace app\modules\teams\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

use app\modules\tournaments\models\Tournament;
use app\modules\tournaments\models\TournamentMode;
use app\modules\tournaments\models\TeamParticipating;
use app\modules\tournaments\models\Cup;

use app\modules\platformgames\models\Games;

use app\modules\user\models\User;

/**
 * Class SubTeam
 * @package app\modules\teams\models
 *
 * @property int $id
 * @property int $main_team_id
 * @property int $game_id
 * @property int $tournament_mode_id
 * @property int $headquater_id
 * @property int $language_id
 * @property int $captain_id
 * @property int $deputy_id
 * @property int $manager_id
 * @property int $trainer_id
 * @property string $name
 * @property string $short_code
 * @property bool $mixed
 * @property string $main_short_code
 * @property string $description
 * @property bool $disqualified
 * @property string $twitter_account
 * @property string $twitter_channel
 * @property string $discord_server
 */
class SubTeam extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'sub_team';
    }

    /**
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
	}

    /**
     * @return int main team id
     */
    public function getMainTeamId()
    {
        return $this->main_team_id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainTeam()
    {
        return $this->hasOne(MainTeam::className(), ['id' => 'main_team_id']);
    }

    /**
     * @return int game id
     */
    public function getGameId()
    {
        return $this->game_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getGameName()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    /**
     * @return int tournament mode id
     */
    public function getTournamentModeId()
    {
        return $this->tournament_mode_id;
    }

    /**
     * @return int tournament mode id
     */
    public function getTournamentModeMaxPlayers()
    {
        return $this->hasOne(TournamentMode::className(), ['id' => 'tournament_mode_id'])->one()->getMaxPlayer();
    }

    /**
     * @return int tournament mode id
     */
    public function getTournamentModeMaxMainPlayers()
    {
        $maxPlayers = $this->hasOne(TournamentMode::className(), ['id' => 'tournament_mode_id'])->one()->getMaxPlayer();
        return $maxPlayers - $this->hasOne(TournamentMode::className(), ['id' => 'tournament_mode_id'])->one()->getSubPlayer();
    }

    /**
     * @return int tournament mode id
     */
    public function getTournamentModeMaxSubPlayers()
    {
        return $this->hasOne(TournamentMode::className(), ['id' => 'tournament_mode_id'])->one()->getSubPlayer();
    }

    /**
     * @return ActiveQuery
     */
    public function getTournamentMode()
    {
        return $this->hasOne(TournamentMode::className(), ['id' => 'tournament_mode_id']);
    }

    /**
     * @return int headquater id
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
     * @return int language id
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
     * @return int captain id
     */
    public function getTeamCaptainId()
    {
        return $this->captain_id;
    }

	/**
     * @return ActiveQuery
     */
    public function getTeamCaptain()
    {
        return $this->hasOne(User::className(), ['id' => 'captain_id']);
    }

    /**
     * @return int deputy id
     */
    public function getTeamDeputyId()
    {
        return $this->deputy_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamDeputy()
    {
        return $this->hasOne(User::className(), ['id' => 'deputy_id']);
    }

    /**
     * @return int manager id
     */
    public function getTeamManagerId()
    {
        return $this->manager_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamManager()
    {
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
    }

    /**
     * @return int trainer id
     */
    public function getTeamTrainerId()
    {
        return $this->trainer_id;
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamTrainer()
    {
        return $this->hasOne(User::className(), ['id' => 'trainer_id']);
    }

    /**
     * @return string team name
     */
    public function getTeamName()
    {
        return $this->name;
    }

    /** Deprecated
     * @return string team name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string short code
     */
    public function getTeamShortCode()
    {
        return $this->short_code;
    }

    /**
     * @return bool mixed Short Code
     */
    public function getIsTeamShortCodeMixed()
    {
        return $this->mixed;
    }

    /**
     * @return string short code
     */
    public function getMainTeamShortCode()
    {
        return $this->main_short_code;
    }

    /**
     * @return string team description
     */
    public function getTeamDescription()
    {
        return $this->description;
    }

    /**
     * @return bool team disqualified
     */
    public function getIsTeamDisqualified()
    {
        return $this->disqualified;
    }

    /**
     * @param $tournamentId
     * @return string
     */
    public function getDisqualifiedStatus($tournamentId)
    {
        /** @var PlayerParticipating $isParticipating */
        //$isParticipating = $this->getPlayerParticipating()->where(['tournament_id' => $tournamentId])->one();
        //return $isParticipating->getDisqualified() != null;
        //return $this->disqualified;
        return false;
    }

    public function getPlayedInRunningSeason()
    {
        $returnValue = 0;

        $runningCups = Cup::findAll(['is_running' => true]);
        //print_r($runningCups); die();


        if(count($runningCups) > 0)
        {
            foreach ($runningCups as $cup) {

                $runningTournaments = Tournament::findAll(['cup_id' => $cup->getId()]);

                foreach ($runningTournaments as $tournament) {

                    //$teamParticipating = $this->getTeamParticipating()->where(['tournament_id' => $tournaments->getId()]);

                    $teamParticipating = $this->getCheckInStatus($tournament->getId());

                    //print_r($teamParticipating); die();

                    $returnValue = ($teamParticipating) ? true : $returnValue;
                }
            }
        }

        return $returnValue;
    }

    /**
     * @return string team twitter account
     */
    public function getTeamTwitterAccount()
    {
        return $this->twitter_account;
    }

    /**
     * @return string team twitter channel
     */
    public function getTeamTwitterChannel()
    {
        return $this->twitter_channel;
    }

    /**
     * @return string team discord server
     */
    public function getTeamDiscordServer()
    {
        return $this->discord_server;
    }

    /**
     * @param $userId
     * @return bool
     */
    public function isUserSubstitute($userId)
    {
        return $this->hasOne(SubTeamMember::className(), ['sub_team_id' => 'id'])->where(['user_id' => $userId, 'is_sub' => 1])->count() == 1;
    }

    /**
     * @return ActiveQuery
     */
    public function getSubTeamMembers()
    {
        return $this->hasMany(SubTeamMember::className(), ['sub_team_id' => 'id']);

        $members = [];
        //$members[] = $this->hasOne(User::className(), ['id' => 'owner_id'])->one();
        foreach ($this->hasMany(SubTeamMember::className(), ['sub_team_id' => 'id'])->all() as $teamMemberKey => $teamMember) {
            $members[] = $teamMember->getUser()->one();
        }

        if (true) {
            usort($members, function($a, $b) {
                return $a->getUsername() > $b->getUsername();
            });
        }

        return $members;

    }

    /**
     * @return ActiveQuery
     */
    public function getSubTeamMembersCount()
    {
        return $this->getSubTeamMembers()->count();
    }

    /**
     * @return ActiveQuery
     */
    public function getSubTeamMainMembersCount()
    {
        return $this->hasMany(SubTeamMember::className(), ['sub_team_id' => 'id'])->where(['is_sub' => 0])->count();
    }

    /**
     * @return ActiveQuery
     */
    public function getSubTeamSubMembersCount()
    {
        return $this->hasMany(SubTeamMember::className(), ['sub_team_id' => 'id'])->where(['is_sub' => 1])->count();
    }

    /**
     * @param $gameId
     * @return array
     */
    public function getTeamHierarchyByGame($gameId)
    {

        $teamHierarchy = array();

        /** @var SubTeam[] $subTeams */
        $subTeams = static::findAll(['game_id' => $gameId]);
        usort($subTeams, function ($a, $b) {

             $aName = $a->getMainTeam()->one()->getName();
             $bName = $b->getMainTeam()->one()->getName();

            $aSubName = $a->getTeamName();
            $bSubName = $b->getTeamName();

            // return [$aName, $a->getTournamentModeId(), $aSubName] <=> [$bName, $b->getTournamentModeId(), $bSubName];
            return [$a->getTournamentModeId(), $aSubName] <=> [$b->getTournamentModeId(), $bSubName];
        });

        foreach ($subTeams as $key => $subTeam) {
            /** @var MainTeam $mainTeam */
            $mainTeam = $subTeam->getMainTeam()->one();
            // $subTeamMember = $subTeam->getSubTeamMembers()->orderBy('is_sub')->all();

            if (!array_key_exists($mainTeam->getId(), $teamHierarchy)) {
                $teamHierarchy[$mainTeam->getId()] = array(
                    'mainTeam' => $mainTeam,
                    'subTeams' => array(),
                );
            }

            $subTeamModeId = $subTeam->getTournamentMode()->one()->getName();

            $teamHierarchy[$mainTeam->getId()]['subTeams'][$subTeamModeId][] = array(
                'subTeam' => $subTeam,
                // 'subTeamMember' => $subTeamMember,
            );
        }

        usort($teamHierarchy, function($a, $b) {
            return strcasecmp($a['mainTeam']->getName(), $b['mainTeam']->getName());
            // return $a['mainTeam']->getName() > $b['mainTeam']->getName();
        });

        return $teamHierarchy;
    }

    public function getTeamParticipating()
    {
        return $this->hasMany(TeamParticipating::className(), ['sub_team_id' => 'id']);
    }

    /**
     * @param int $tournamentId
     * @return string
     */
    public function getCheckInStatus($tournamentId)
    {
        /** @var TeamParticipating $isParticipating */
        $isParticipating = $this->getTeamParticipating()->where('tournament_id = ' . $tournamentId)->one();
        
        if($isParticipating != null)
            return $isParticipating->getIsCheckedin() != null;
        else
            return false;
    }

    /**
     * @return string
     */
    public function getTeamMembersFormatted()
    {
        $users = $this->getSubTeamMembers()->orderBy('is_sub')->all();
        //$users = SubTeam::findOne(['id' => 1])->getSubTeamMembers();

        //print_r($users); die();

        $userString = array_map(function ($arr) {
            $userName = $arr->getUser()->one()->getUsername();
            $isSub = (1 === $arr->getIsSubstitute()) ? 'Substitute' : 'Spieler';
            return $userName . ' (' . $isSub . ')';
        }, $users);

        return implode('<br>', $userString);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
}