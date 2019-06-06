<?php

namespace app\modules\tournamenttrees\models;

use yii\db\ActiveRecord;

use app\modules\tournamenttrees\models\Bracket;
use app\modules\teams\models\SubTeam;
use app\modules\user\models\User;


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
     * @return ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
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

			$game_round = $encounter->game_round;
			$player_id = $encounter->player_id;

			$output[$game_round][$player_id] = [
				'points'  => $encounter->points,
				'goals'   => $encounter->goals,
				'assists' => $encounter->assists,
				'saves'   => $encounter->saves,
				'shots'   => $encounter->shots,
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

	public static function getGoals($tournament_id, $bracket_id, $best_of)
	{
		$encounters = self::findAll(['tournament_id' => $tournament_id, 'bracket_id' => $bracket_id]);

		if (count($encounters) == 0) {
			return ['left' => [], 'right' => []];
		}

		$players_left = self::getPlayers($bracket_id, 'left');
		$players_right = self::getPlayers($bracket_id, 'right');

		$leftGoals = [];
		$rightGoals = [];

		foreach ($encounters as $key => $encounter) {

			foreach ($players_left as $key => $player) {
				if ($player->getId() == $encounter->player_id) {
					$leftGoals[$encounter->game_round] += $encounter->goals;
				}
			}

			foreach ($players_right as $key => $player) {
				if ($player->getId() == $encounter->player_id) {
					$rightGoals[$encounter->game_round] += $encounter->goals;
				}
			}
		}

		return ['left' => $leftGoals, 'right' => $rightGoals];
	}

	/**
	 * @param int
	 * @param string
	 * @return array
	 */
	public static function getPlayers($bracket_id, $left_right)
	{
		$bracket = Bracket::getById($bracket_id);

        if ($bracket->team_1_id === NULL) {
        	if ('left' === $left_right) {
	            $player  = User::findIdentity($bracket->user_1_id);
	            $player_arr = [$player];
	        } else if ('right' === $left_right) {
    	        $player = User::findIdentity($bracket->user_2_id);
            	$player_arr = [$player];
	        }

        } else {
        	if ('left' === $left_right) {

	            $player  = SubTeam::findIdentity($bracket->team_1_id);
            	$members = $player->getSubTeamMembers()->all();

	            foreach ($members as $key => $member) {
	                if (NULL === $member) {
	                    continue;
	                }

	                $user = $member->getUser()->one();
	                if (NULL === $user) {
	                    continue;
	                }

	                $player_arr[] = $user;
	            }

        	} else  if ('right' === $left_right) {

	            $player = SubTeam::findIdentity($bracket->team_2_id);
	            $members = $player->getSubTeamMembers()->all();

	            foreach ($members as $key => $member) {
	                if (NULL === $member) {
	                    continue;
	                }

	                $user = $member->getUser()->one();
	                if (NULL === $user) {
	                    continue;
	                }

	                $player_arr[] = $user;
	            }
        	}

        }

        return $player_arr;

	}

	/**
	 * @param int
	 * @param int
	 * @return bool
	 */
	public static function getWinner($tournament_id, $bracket_id, $best_of)
	{
		$encounters = self::findAll(['tournament_id' => $tournament_id, 'bracket_id' => $bracket_id]);

		if (count($encounters) == 0) {
			return false;
		}

		$players_left = self::getPlayers($bracket_id, 'left');
		$players_right = self::getPlayers($bracket_id, 'right');

		$leftGoals = [];
		$rightGoals = [];

		foreach ($encounters as $key => $encounter) {

			foreach ($players_left as $key => $player) {
				if ($player->getId() == $encounter->player_id) {
					$leftGoals[$encounter->game_round] += $encounter->goals;
				}
			}

			foreach ($players_right as $key => $player) {
				if ($player->getId() == $encounter->player_id) {
					$rightGoals[$encounter->game_round] += $encounter->goals;
				}
			}

		}

		$minGames = ceil($best_of / 2);

		if (count($leftGoals) != count($rightGoals)) {
			return false;
		}

		if (count($leftGoals) < $minGames) {
			return false;
		}

		$leftWins = 0;
		$rightWins = 0;

		foreach ($leftGoals as $round => $value) {
			if ($leftGoals[$round] > $rightGoals[$round]) {
				$leftWins++;
			} else if ($leftGoals[$round] < $rightGoals[$round]) {
				$rightWins++;
			}
		}

		if ($leftWins == $minGames) {
			return 1;
		}

		if ($rightWins == $minGames) {
			return 2;
		}

		return false;
	}

}