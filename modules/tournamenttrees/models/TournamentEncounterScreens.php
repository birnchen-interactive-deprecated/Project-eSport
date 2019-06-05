<?php

namespace app\modules\tournamenttrees\models;

use yii\db\ActiveRecord;

/**
 * Class TournamentEncounter
 * @package app\modules\tournamenttree\models
 *
 * @property int $bracket_id
 * @property int $tournament_id
 * @property int $game_round
 * @property blob $screenshot
 */


class TournamentEncounterScreens extends ActiveRecord {

	/**
     * @return string
     */
    public static function tableName()
    {
        return 'tournament_encounter_screens'; // Tabellenname gegebenenfalls ändern??
    }

    /**
	 * @return int bracket_id
	 */
	public function getBracketId()
	{
		return $this->bracket_id;
	}

	/**
	 * @return int tournament_id
	 */
	public function getTournamentId()
	{
		return $this->tournament_id;
	}

	/**
	 * @param int
	 */
	public function setBracketId($bracket_id)
	{
		$this->bracket_id = $bracket_id;
	}

	/**
	 * @param int
	 */
	public function setTournamentId($tournament_id)
	{
		$this->tournament_id = $tournament_id;
	}

	/**
	 * @param int
	 */
	public function setGameRound($game_round)
	{
		$this->game_round = $game_round;
	}

	/**
	 * @param string
	 */
	public function setScreenshot($webp_content)
	{
		$this->screenshot = $webp_content;
	}

	/**
	 * @return array
	 */
	public static function getByFullKey($tournament_id, $bracket_id, $game_round)
	{
		return self::findOne(['tournament_id' => $tournament_id, 'bracket_id' => $bracket_id, 'game_round' => $game_round]);
	}

}