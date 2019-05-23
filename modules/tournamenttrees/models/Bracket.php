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
	 * @return string
	 */
	public function getParticipant1()
	{
		$class = NULL;
		$vars = NULL;
		if ($this->getTeam1() !== NULL) {
			$class = SubTeam::className();
			$vars = ['id' => 'team_1_id'];
		}
		if ($this->getPlayer1() !== NULL) {
			$class = User::className();
			$vars = ['id' => 'user_1_id'];
		}
return var_export($class, true);
		if (NULL === $class) {
			return 'Empty Slot';
		}
		$slot = $this->hasOne($class, $vars)->one();

		if (NULL === $slot) {
			return 'Empty Slot';
		}

		if ($slot instanceof User) {
			return $slot->getUsername();
		}
		if ($slot instanceof SubTeam) {
			return $slot->getName();
		}
		return 'nix';
	}

	/**
	 * @return string
	 */
	public function getParticipant2()
	{
		$class = NULL;
		$vars = NULL;
		if ($this->getTeam2() !== NULL) {
			$class = SubTeam::className();
			$vars = ['id' => 'team_2_id'];
		}
		if ($this->getPlayer2() !== NULL) {
			$class = User::className();
			$vars = ['id' => 'user_2_id'];
		}
return var_export($class, true);
		if (NULL === $class) {
			return 'Empty Slot';
		}
		$slot = $this->hasOne($class, $vars)->one();

		if (NULL === $slot) {
			return 'Empty Slot';
		}

		if ($slot instanceof User) {
			return $slot->getUsername();
		}
		if ($slot instanceof SubTeam) {
			return $slot->getName();
		}
		return var_export($slot, true);
	}

	/**
	 * @param User|SubTeam
	 */
	public function setSpieler($participant)
	{

		if ($participant instanceof User) {

			if (NULL === $this->user_1_id) {
				$this->user_1_id = $participant->getId();
			} else {
				$this->user_2_id = $participant->getId();
			}

		} elseif ($participant instanceof SubTeam) {

			if (NULL === $this->team_1_id) {
				$this->team_1_id = $participant->getId();
			} else {
				$this->team_2_id = $participant->getId();
			}

		}

	}

	/**
	 * @param int
	 * @return static|null
	 */
	public static function getAllByTournament($tournament_id)
	{
		return static::findAll(['tournament_id' => $tournament_id]);
	}
}