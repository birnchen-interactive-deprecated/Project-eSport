<?php

namespace app\modules\tournaments\models;

use yii\db\ActiveRecord;

use app\modules\tournaments\models\Cup;

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
        $season = 'S' . $cup->getSeason();

        $modeName = $tMode->getName();

        $dayName = $this->getName();

        return $cupName . ' ' . $season . ' ' . $modeName . ' ' . $dayName;
    }
}