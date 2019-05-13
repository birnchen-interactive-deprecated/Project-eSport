<?php

namespace app\modules\platformgames\models\formModels;

use app\components\FormModel;
use app\widgets\Alert;

use app\modules\platformgames\models\Games;
use app\modules\platformgames\models\Platforms;
use app\modules\platformgames\models\UserGames;

use Yii;
use yii\db\Exception;
use yii\db\Expression;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class UserGameForm extends FormModel
{
    public $game_id;
    public $platform_id;
    public $player_id;
    public $visible = true;

    /**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [
			[
            	['game_id', 'platform_id', 'player_id'],
            	'required',
        	],
        	[
        		'game_id',
        		'exist',
        		'targetClass' => Games::className(),
    			'targetAttribute' => 'id'
        	],
        	[
            	'platform_id',
            	'exist',
        		'targetClass' => Platforms::className(),
        		'targetAttribute' => 'id'
        	]
		];
	}

	/**
     * Creates a new user, or updates an existing one.
     *
     * @return boolean true, if the user was saved successfully
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\Exception
     */
	public function save()
	{
		$transaction = Yii::$app->db->beginTransaction();
		$userGames = new UserGames();
		$userGames->game_id = $this->game_id;
		$userGames->user_id = Yii::$app->user->identity->getId();
		$userGames->platform_id = $this->platform_id;
		$userGames->player_id = $this->player_id;

		try {
			$userGames->save();
			$transaction->commit();
			
		} catch (Exception $e) {
			print_r($e->getMessage());
            $transaction->rollBack();
            //Alert::addError(Module::t("general", "user %s couldn't be saved"), $user->getUsername());
		}
		return false;
	}
}