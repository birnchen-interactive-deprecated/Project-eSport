<?php

namespace app\modules\tournaments\models;

use yii\db\ActiveRecord;
use yii\helpers\Html;

use app\modules\tournaments\models\Cup;
use app\modules\user\models\User;
use app\modules\teams\models\SubTeam;
use app\modules\teams\models\SubTeamMember;

use app\modules\rules\models\TournamentRulesSet;
use app\modules\rules\models\TournamentRulesSubrules;

use app\modules\tournaments\models\TournamentBracketMode;

/**
 * Class GCup
 * @package app\modules\tournament\models
 *
 * @property int $id
 * @property int $game_id
 * @property int $mode_id
 * @property int $bracket_mode_id
 * @property int $cup_id
 * @property int $rules_id
 * @property string $dt_starting_time
 * @property string $dt_register_open
 * @property string $dt_register_close
 * @property string $dt_checkin_open
 * @property string $dt_checkin_close
 * @property bool $has_password
 * @property string $password
 * @property string $twitter_channel
 */
class Tournament extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'tournament';
    }

	/**
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
	}

    /**
     * Finds tournament by id.
     *
     * @param string $tournamentname the name
     * @return static|null the tournament, if a tournament with that tournament name exists
     */
    public static function getTournamentById($tournamentId)
    {
        return static::findOne(['id' => $tournamentId]);
    }

	/**
	 * @return int id
	 */
	public function getGameId()
	{
		return $this->game_id;
	}

	/**
	 * @return int id
	 */
	public function getModeId()
	{
		return $this->mode_id;
	}

    /**
     * @return ActiveQuery
     */
    public function getMode()
    {
        return $this->hasOne(TournamentMode::className(), ['id' => 'mode_id']);
    }

	/**
	 * @return int id
	 */
	public function getBracketModeId()
	{
		return $this->bracket_mode_id;
	}

    /**
     * @return ActiveQuery
     */
    public function getBracketMode()
    {
        return $this->hasOne(TournamentBracketMode::className(), ['id' => 'bracket_mode_id']);
    }

	/**
	 * @return int id
	 */
	public function getCupId()
	{
		return $this->cup_id;
	}

	/**
	 * @return int id
	 */
	public function getRulesId()
	{
		return $this->rules_id;
	}

    /**
     * Get Rules Name
     */
    public function getRules()
    {
        $baseRuleSet = $this->getBaseRuleSet()->one();
        $subRuleSet = $this->getSubRuleSet()->all();

        $rulesName = [
            'baseSet' => $baseRuleSet->getName(),
            'subRulesSet' => $subRuleSet,
        ];

        return $rulesName;
    }

    /**
     * @return ActiveQuery
     */
    public function getBaseRuleSet()
    {
        return $this->hasOne(TournamentRulesSet::className(), ['id' => 'rules_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubRuleSet()
    {
        return $this->hasMany(TournamentRulesSubrules::className(), ['rules_set_id' => 'rules_id']);
    }

	/**
	 * @return string name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
     * @return string
     */
    public function getDtStartingTime()
    {
        return $this->dt_starting_time;
    }

    /**
     * @return string
     */
    public function getDtRegisterOpen()
    {
        return $this->dt_register_open;
    }

    /**
     * @return string
     */
    public function getDtRegisterClose()
    {
        return $this->dt_register_close;
    }

    /**
     * @return string
     */
    public function getDtCheckinOpen()
    {
        return $this->dt_checkin_open;
    }

    /**
     * @return string
     */
    public function getDtCheckinClose()
    {
        return $this->dt_checkin_close;
    }

    /**
     * @return bool
     */
    public function getHasPassword()
    {
        return $this->has_password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getTwitterChannel()
    {
        return $this->twitter_channel;
    }

    /**
     * @return Tournament[]
     */
    public static function getTournament($tournamentId)
    {
        //TODO: Die 1 als RL Id solltet ihr in die Constants auslagern. Im Idealfall solltet ihr sogar ne Spiele Tabelle in der DB haben.
        return static::findAll(['game_id' => $tournamentId]);
    }

    /**
     * @return ActiveQuery
     */
    public function getCup()
    {
        return $this->hasOne(Cup::className(), ['id' => 'cup_id']);
    }

    /**
     * @return string
     */
    public function showRealTournamentName()
    {
        $cup = $this->getCup()->one();;
        $tMode = $this->getMode()->one();

        $cupName = $cup->getName();
        $season = $cup->getSeason();

        $modeName = $tMode->getName();

        $dayName = $this->getName();

        return $cupName . ' ' . $season . ' ' . $modeName . ' ' . $dayName;
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getParticipants()
    {
        if ($this->getMode()->one()->getMaxPlayer() == 1) {
            return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('player_participating', ['tournament_id' => 'id']);
        }

        return $this->hasMany(SubTeam::className(), ['id' => 'sub_team_id'])->viaTable('team_participating', ['tournament_id' => 'id']);
    }

    /**
     * @param $subTeams
     * @return boolean
     */
    public function showRegisterBtn($subTeams, $user) {
        if ($this->getMode()->one()->getMaxPlayer() == 1) {

            if (NULL === $user) {
                return false;
            }

            $gameFound = false;
            $userGames = $user->getGames()->all();
            foreach ($userGames as $key => $userGame) {
                
                if ($userGame->getGameId() !== $this->game_id) {
                    continue;
                }

                if (!preg_match('/.*#[0-9]{4}$/', $userGame->getPlayerId())) {
                    continue;
                }

                $gameFound = true;
            }
            return true;
        }

        if (count($subTeams) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param $subTeams
     * @param $user
     * @return array
     */
    public function getRegisterBtns($subTeams, $user)
    {
        if ($this->getMode()->one()->getMaxPlayer() == 1) {

            $isParticipating = $this->checkPlayerParticipating($user);

            $btnValue = ($isParticipating) ? 'Abmelden' : 'Registrieren';
            $btnColor = ($isParticipating) ? 'btn-danger' : 'btn-success';

            $tmp = array(
                array(
                    'type' => 'user',
                    'id' => $user->getId(),
                    'name' => Html::tag('span', $user->getUsername()),
                    'btn' => Html::submitInput($btnValue, ['class' => 'btn ' . $btnColor, 'name' => 'submitText']),
                ),
            );
            return $tmp;
        }

        $retArr = array();
        foreach ($subTeams as $key => $subTeam) {

            if ($subTeam->getTournamentModeId() !== $this->getModeId()) {
                continue;
            }

            $modeMaxPlayers = $this->getMode()->one()->getMaxPlayer();
            $modeSubPlayers = $this->getMode()->one()->getSubPlayer();
            $modeMainPlayers = $modeMaxPlayers - $modeSubPlayers;

            $mainFound = 0;
            $playersWithRLID = 0;
            $teamMembers = SubTeamMember::getTeamMembers($subTeam->getId());
            foreach ($teamMembers as $teamMemberKey => $teamMember) {

                $isSub = false;
                if ($teamMember->getIsSubstitute() !== 0) {
                    $isSub = true;
                }

                $userGames = $teamMember->getUser()->one()->getGames()->all();
                foreach ($userGames as $key => $userGame) {

                    if ($userGame->getGameId() !== $this->game_id) {
                        continue;
                    }

                    if (!preg_match('/.*#[0-9]{4}$/', $userGame->getPlayerId())) {
                        continue;
                    }

                    if (!$isSub) {
                        $mainFound++;
                    }
                    $playersWithRLID++;
                }

            }

            if ($mainFound < $modeMainPlayers) {
                continue;
            }

            if ($playersWithRLID < count($teamMembers)) {
                continue;
            }

            $isParticipating = $this->checkTeamParticipating($subTeam);

            $btnValue = ($isParticipating) ? 'Abmelden' : 'Registrieren';
            $btnColor = ($isParticipating) ? 'btn-danger' : 'btn-success';

            $retArr[] = array(
                'type' => 'subTeam',
                'id' => $subTeam->getId(),
                'name' => Html::tag('span', $subTeam->getTeamName()),
                'btn' => Html::submitInput($btnValue, ['class' => 'btn ' . $btnColor, 'name' => 'submitText']),
            );

        }

        return $retArr;

    }

    /**
     * @param $subTeams
     * @param $user
     * @return array
     */
    public function getCheckInBtns($subTeams, $user)
    {
        $retArr = array();
        $modeMaxPlayers = $this->getMode()->one()->getMaxPlayer();

        if ($modeMaxPlayers == 1) {

            if (NULL === $user) {
                return $retArr;
            }

            $isParticipating = $this->checkPlayerCheckedIn($user);

            $btnValue = ($isParticipating) ? 'Check-Out' : 'Check-In';
            $btnColor = ($isParticipating) ? 'btn-danger' : 'btn-success';

            $tmp = array(
                array(
                    'type' => 'user',
                    'id' => $user->getId(),
                    'name' => Html::tag('span', $user->getUsername()),
                    'btn' => Html::submitInput($btnValue, ['class' => 'btn ' . $btnColor, 'name' => 'submitText']),
                ),
            );
            return $tmp;
        }

        foreach ($subTeams as $key => $subTeam) {

            if ($subTeam->getTournamentModeId() !== $this->getModeId()) {
                continue;
            }

            $mainFound = 0;
            $teamMembers = SubTeamMember::getTeamMembers($subTeam->getId());
            foreach ($teamMembers as $teamMemberKey => $teamMember) {
                if ($teamMember->getIsSubstitute() === 0) {
                    $mainFound++;
                }
            }

            $modeSubPlayers = $this->getMode()->one()->getSubPlayer();
            $modeMainPlayers = $modeMaxPlayers - $modeSubPlayers;

            if ($mainFound < $modeMainPlayers) {
                continue;
            }

            $isParticipating = $this->checkTeamParticipating($subTeam);
            if (!$isParticipating) {
                continue;
            }

            $isParticipating = $this->checkTeamCheckedIn($subTeam);

            $btnValue = ($isParticipating) ? 'Check-Out' : 'Check-In';
            $btnColor = ($isParticipating) ? 'btn-danger' : 'btn-success';

            $retArr[] = array(
                'type' => 'subTeam',
                'id' => $subTeam->getId(),
                'name' => Html::tag('span', $subTeam->getName()),
                'btn' => Html::submitInput($btnValue, ['class' => 'btn ' . $btnColor, 'name' => 'submitText']),
            );

        }

        return $retArr;

    }

    /**
     * @param $user
     * @return boolean
     */
    private function checkPlayerParticipating($user)
    {
        return PlayerParticipating::findPlayerParticipating($this->id, $user->getId()) != null;
    }

    /**
     * @param $subTeam
     * @return boolean
     */
    private function checkTeamParticipating($subTeam)
    {
        return TeamParticipating::findTeamParticipating($this->id, $subTeam->getId()) != null;
    }

    /**
     * @param $user User
     * @return boolean
     */
    private function checkPlayerCheckedIn($user)
    {
        return PlayerParticipating::findPlayerCheckedIn($this->id, $user->getId()) != null;
    }

    /**
     * @param $subTeam SubTeam
     * @return boolean
     */
    private function checkTeamCheckedIn($subTeam)
    {
        return TeamParticipating::findTeamCheckedIn($this->tournament_id, $subTeam->getId()) != null;
    }

}