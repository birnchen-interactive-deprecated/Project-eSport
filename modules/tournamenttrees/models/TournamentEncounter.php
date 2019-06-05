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
 * @property int $player_id
 * @property int points
 * @property int goals
 * @property int assists
 * @property int saves
 * @property int shots
 */

class TournamentEncounter extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'tournament_encounter'; // Tabellenname gegebenenfalls ändern??
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
	 * @param int
	 * @param array
	 */
	public function setDataForPlayer($player_id, $pointsArr)
	{
		$this->player_id = $player_id;

		// im Array müssen die gleichen Felder sein, wie hier beschrieben:
		// points, goals, assists, saves, shots
		foreach ($pointsArr as $key => $value) {
			$this->$key = $value;
		}
		
	}

}