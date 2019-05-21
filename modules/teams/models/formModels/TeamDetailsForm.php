<?php

namespace app\modules\teams\models\formModels;

use app\components\FormModel;

use app\widgets\Alert;

use app\modules\user\models\User;
use app\modules\user\models\Language;
use app\modules\user\models\Nationality;

use Yii;
use yii\db\Expression;
use yii\db\Exception;

/**
 * TeamDetailForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class TeamDetailsForm extends FormModel
{
		public $id;
		public $main_team_id;
		public $game_id;
		public $tournament_mode_id;
		public $headquater_id;
		public $language_id;
		public $captain_id;
		public $deputy_id;
		public $manager_id;
		public $trainer_id;
		public $name;
		public $short_code;
		public $mixed;
		public $main_short_code;
		public $description;
		public $disqualified;
		public $twitter_account;
		public $twitter_channel;
		public $discord_server;
}