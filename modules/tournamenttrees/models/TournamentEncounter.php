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
	 */
	public function setPlayerId($player_id)
	{
		$this->player_id = $player_id;
	}

	/**
	 * @param int
	 * @param array
	 */
	public function setData($pointsArr)
	{
		// im Array müssen die gleichen Felder sein, wie hier beschrieben:
		// points, goals, assists, saves, shots
		foreach ($pointsArr as $key => $value) {
			$this->$key = $value;
		}

	}

	/**
	 * @param int
	 * @param int
	 * return array
	 */
	public static function getDataFromTournamentBracket($tournament_id, $bracket_id)
	{
		$encounters = self::findAll(['tournament_id' => $tournament_id, 'bracket_id' => $bracket_id]);

		$output = [];
		foreach ($encounters as $key => $encounter) {

			$game_round = $encounter['game_round'];
			$player_id = $encounter['player_id'];

			$output[$game_round][$player_id] = [
				'points'  => $encounter['points'],
				'goals'   => $encounter['goals'],
				'assists' => $encounter['assists'],
				'saves'   => $encounter['saves'],
				'shots'   => $encounter['shots'],
			];

		}

		return $output;
	}

	/**
	 * @return array
	 */
	public static function getByFullKey($tournament_id, $bracket_id, $game_round, $player_id)
	{
		return self::findOne(['tournament_id' => $tournament_id, 'bracket_id' => $bracket_id, 'game_round' => $game_round, 'player_id' => $player_id]);
	}

}