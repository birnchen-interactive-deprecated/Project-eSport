<?php

namespace app\modules\tournamenttrees\models;

use yii\db\ActiveRecord;

/**
 * Class TournamentEncounterConfirm
 * @package app\modules\tournamenttree\models
 *
 * @property int $bracket_id
 * @property int $tournament_id
 * @property int $player_1_confirm
 * @property int $player_2_confirm
 */


class TournamentEncounterConfirm extends ActiveRecord {

	/**
     * @return string
     */
    public static function tableName()
    {
        return 'tournament_encounter_confirm'; // Tabellenname gegebenenfalls ändern??
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
	 * @return array
	 */
	public static function getByFullKey($tournament_id, $bracket_id)
	{
		return self::findOne(['tournament_id' => $tournament_id, 'bracket_id' => $bracket_id]);
	}

	/**
	 * @return bool
	 */
	public static function isConfirmeable($tournament_id, $bracket_id, $left, $right)
	{
		$encounterConfirm = self::findOne(['tournament_id' => $tournament_id, 'bracket_id' => $bracket_id]);

		if (NULL === $encounterConfirm) {
			return true;
		}

		if ($left && $encounterConfirm->player_1_confirm === NULL) {
			return true;
		}

		if ($right && $encounterConfirm->player_2_confirm === NULL) {
			return true;
		}

		return false;
	}

}