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
	 * @return array
	 */
	public function getBracketRefs()
	{
		$winner = $this->hasMany(Bracket::className(), ['id' => 'winner_bracket'])->all();
		$looser = $this->hasMany(Bracket::className(), ['id' => 'looser_bracket'])->all();

		$brackets = [];
		while ($tmp = array_shift($looser)) {
			$brackets[] = $tmp;
		}
		while ($tmp = array_shift($winner)) {
			$brackets[] = $tmp;
		}

		return $brackets;
	}

	/**
	 * @return array
	 */
	public function getParticipants()
	{
		$return = [];

		$refs = $this->getBracketRefs();

		$class = NULL;
		$vars = NULL;
		if ($this->getTeam1()->one() !== NULL) {
			$class = SubTeam::className();
			$vars = ['id' => 'team_1_id'];
		}
		if ($this->getPlayer1()->one() !== NULL) {
			$class = User::className();
			$vars = ['id' => 'user_1_id'];
		}

		if (NULL === $class) {

			if (count($refs) === 0) {
				$return[] = 'FREILOS';
			} else {
				$preBracket = array_shift($refs);
				$preText = ($preBracket->winner_bracket == $this->getId()) ? 'Winner' : 'Looser';
				$return[] = ' von Runde ' . $preBracket->getTournamentRound() . ' Bracket ' . $preBracket->getEncounterId();
			}
		} else {
			$slot = $this->hasOne($class, $vars)->one();
			if ($slot instanceof User) {
				$return[] = $slot->getUsername();
			} else if ($slot instanceof SubTeam) {
				$return[] = $slot->getName();
			} else {
				$return[] = '';
			}

		}


		$class = NULL;
		$vars = NULL;
		if ($this->getTeam2()->one() !== NULL) {
			$class = SubTeam::className();
			$vars = ['id' => 'team_2_id'];
		}
		if ($this->getPlayer2()->one() !== NULL) {
			$class = User::className();
			$vars = ['id' => 'user_2_id'];
		}

		if (NULL === $class) {

			if (count($refs) === 0) {
				$return[] = 'FREILOS';
			} else {
				$preBracket = array_shift($refs);
				$preText = ($preBracket->winner_bracket == $this->getId()) ? 'Winner' : 'Looser';
				$return[] = ' von Runde ' . $preBracket->getTournamentRound() . ' Bracket ' . $preBracket->getEncounterId();
			}
		} else {
			$slot = $this->hasOne($class, $vars)->one();
			if ($slot instanceof User) {
				$return[] = $slot->getUsername();
			} else if ($slot instanceof SubTeam) {
				$return[] = $slot->getName();
			} else {
				$return[] = '';
			}

		}

		return $return;
	}

	/**
	 * @return string
	 */
	// public function getParticipant1()
	// {
	// 	$class = NULL;
	// 	$vars = NULL;
	// 	if ($this->getTeam1()->one() !== NULL) {
	// 		$class = SubTeam::className();
	// 		$vars = ['id' => 'team_1_id'];
	// 	}
	// 	if ($this->getPlayer1()->one() !== NULL) {
	// 		$class = User::className();
	// 		$vars = ['id' => 'user_1_id'];
	// 	}

	// 	if (NULL === $class) {
	// 		$preText = 'Winner';
	// 		$preBracket = Bracket::getBracketByWinner($this->getId());
	// 		if (NULL === $preBracket) {
	// 			$preText = 'Looser';
	// 			$preBracket == Bracket::getBracketByLooser($this->getId());
	// 		}

	// 		return (NULL === $preBracket) ? 'FREILOS' : $preText . ' von Runde ' . $preBracket->getTournamentRound() . ' Bracket ' . $preBracket->getEncounterId();
	// 	}
	// 	$slot = $this->hasOne($class, $vars)->one();

	// 	if (NULL === $slot) {
	// 		return '!! FEHLER-2 !!';
	// 	}

	// 	if ($slot instanceof User) {
	// 		return $slot->getUsername();
	// 	}
	// 	if ($slot instanceof SubTeam) {
	// 		return $slot->getName();
	// 	}
	// 	return 'nix';
	// }

	/**
	 * @return string
	 */
	// public function getParticipant2()
	// {
	// 	$class = NULL;
	// 	$vars = NULL;
	// 	if ($this->getTeam2()->one() !== NULL) {
	// 		$class = SubTeam::className();
	// 		$vars = ['id' => 'team_2_id'];
	// 	}
	// 	if ($this->getPlayer2()->one() !== NULL) {
	// 		$class = User::className();
	// 		$vars = ['id' => 'user_2_id'];
	// 	}

	// 	if (NULL === $class) {
	// 		$preText = 'Winner';
	// 		$preBracket = Bracket::getBracketByWinner($this->getId());
	// 		if (NULL === $preBracket) {
	// 			$preText = 'Looser';
	// 			$preBracket == Bracket::getBracketByLooser($this->getId());
	// 		}

	// 		return (NULL === $preBracket) ? 'FREILOS' : $preText . ' von Runde ' . $preBracket->getTournamentRound() . ' Bracket ' . $preBracket->getEncounterId();
	// 	}
	// 	$slot = $this->hasOne($class, $vars)->one();

	// 	if (NULL === $slot) {
	// 		return '!! FEHLER-2 !!';
	// 	}

	// 	if ($slot instanceof User) {
	// 		return $slot->getUsername();
	// 	}
	// 	if ($slot instanceof SubTeam) {
	// 		return $slot->getName();
	// 	}
	// 	return var_export($slot, true);
	// }

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

	/**
	 * @param int
	 * @return static|null
	 */
	public static function getBracketByWinner($bracketId) {
		return static::findOne(['winner_bracket' => $bracketId]);
	}

	/**
	 * @param int
	 * @return static|null
	 */
	public static function getBracketByLooser($bracketId) {
		return static::findOne(['looser_bracket' => $bracketId]);
	}
}