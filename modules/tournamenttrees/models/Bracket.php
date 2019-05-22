<?php

namespace app\modules\tournamenttrees\models;

use yii\db\ActiveRecord;

use app\modules\teams\models\SubTeam;
use app\modules\tournaments\models\Tournament;
use app\modules\user\models\User;

/**
 * Class Bracket
 * @package app\modules\tournamenttree\models
 *
 * @property int $id
 * @property int $encounter_id
 * @property int $tournament_id
 * @property int $best_of default:3
 * @property int $tournament_round
 * @property boolean $is_winner_bracket default:true
 * @property SubTeam|NULL $team_1_id
 * @property SubTeam|NULL $team_2_id
 * @property User|NULL $user_1_id
 * @property User|NULL $user_2_id
 * @property Bracket|NULL $winner_bracket
 * @property Bracket|NULL $looser_bracket
 */
class Bracket extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'bracket'; // Tabellenname gegebenenfalls ändern??
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
	public function getEncounterId()
	{
		return $this->encounter_id;
	}

	/**
	 * @return ActiveQuery
	 */
	public function getTournament()
	{
		return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
	}

	/**
	 * @return int best_of
	 */
	public function getBestOf()
	{
		return $this->best_of;
	}

	/**
	 * @return int tournament_round
	 */
	public function getTournamentRound()
	{
		return $this->tournament_round;
	}

	/**
	 * @return boolean is_winner_bracket
	 */
	public function getIsWinnerBracket()
	{
		return $this->is_winner_bracket;
	}

	/**
	 * @return ActiveQuery|NULL
	 */
	public function getTeam1()
	{
		return $this->hasOne(SubTeam::className(), ['id' => 'team_1_id']);
	}

	/**
	 * @return ActiveQuery|NULL
	 */
	public function getTeam2()
	{
		return $this->hasOne(SubTeam::className(), ['id' => 'team_2_id']);
	}

	/**
	 * @return ActiveQuery|NULL
	 */
	public function getPlayer1()
	{
		return $this->hasOne(User::className(), ['id' => 'user_1_id']);
	}

	/**
	 * @return ActiveQuery|NULL
	 */
	public function getPlayer2()
	{
		return $this->hasOne(User::className(), ['id' => 'user_2_id']);
	}

	/**
	 * @return ActiveQuery|NULL
	 */
	public function getWinnerBracket()
	{
		return $this->hasOne(Bracket::className(), ['id' => 'winner_bracket']);
	}

	/**
	 * @return ActiveQuery|NULL
	 */
	public function getLooserBracket()
	{
		return $this->hasOne(Bracket::className(), ['id' => 'looser_bracket']);
	}

	/**
	 *
	 */
	public function setSpieler($participant) {

		if ($participant instanceof User) {

			if (NULL === $this->user_1_id) {
				$this->user_1_id = $participant;
			} else {
				$this->user_2_id = $participant;
			}

		} elseif ($participant instanceof SubTeam) {

			if (NULL === $this->team_1_id) {
				$this->team_1_id = $participant;
			} else {
				$this->team_2_id = $participant;
			}

		}

	}

}