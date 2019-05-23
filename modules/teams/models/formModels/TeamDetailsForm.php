<?php

namespace app\modules\teams\models\formModels;

use app\components\FormModel;

use app\widgets\Alert;

use app\modules\user\models\User;
use app\modules\user\models\Language;
use app\modules\user\models\Nationality;

use app\modules\teams\models\MainTeam;

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
		public $siteLanguage;

		public $team_id;
		public $owner_id;
		public $deputy_id;
		public $headquater_id;
		public $language_id;
		public $name;
		public $description;
		public $short_code;
		public $twitter_account;
		public $twitter_channel;
		public $discord_server;

		/**
     * SubTeamDetailsForm constructor.
     * @param $subTeamId
     * @return SubTeamDetailsForm
     */
    public static function getTeamForm($teamId)
    {
        $teamDetails = MainTeam::findOne(['id' => $teamId]);
        $model = new TeamDetailsForm();
        /** Language */
        $model->siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');
        $model->team_id = $teamId;

        /** Default informations */
        $model->headquater_id = $teamDetails->getHeadquaterId();
        $model->language_id = $teamDetails->getLanguageId();

        /** Management Informations */
        $model->owner_id = $teamDetails->getOwnerId();
        $model->deputy_id = $teamDetails->getDeputyId();

        /** Team Informations */
        $model->name = $teamDetails->getName();
        $model->short_code = $teamDetails->getShortCode();
        $model->description = $teamDetails->getTeamDescription();

        /** Social Media Informations */
        $model->twitter_account = $teamDetails->getTwitterAccount();
        $model->twitter_channel = $teamDetails->getTwitterChannel();
        $model->discord_server = $teamDetails->getDiscordServer();

        return $model;
    }

    /**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [
			[ 'language_id', 'exist', 'targetClass' => Language::className(), 'targetAttribute' => 'id' ],
        	[ 'headquater_id', 'exist',	'targetClass' => Nationality::className(), 'targetAttribute' => 'id' ],
			[ ['owner_id', 'deputy_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id' ],
			[ ['short_code', 'description'], 'required' ],
        	[ 'twitter_channel', 'string' ],
            [ 'name', 'string' ],
			[ 'discord_server', 'customUniqueDiscordValidator' ],
			[ 'twitter_account', 'customUniqueTwitterValidator'],
		];
	}

	public function customUniqueTwitterValidator($attribute, $params)
    {
        $validation = MainTeam::find()->where(['twitter_account' => $this->twitter_account])->one();

        if(empty($validation))
            return true;
        else if ($validation->getId() == $this->id)
            return true;
        else
            true;//$this->addError($attribute, 'Account ' . $this->twitter_account . ' wird bereits verwendet' );
    }
	public function customUniqueDiscordValidator($attribute, $params)
    {
        return true;
    }

    public function customUniqueTeamName($attribute, $params)
    {
        $validationMain = MainTeam::find()->where(['name' => $this->main_team])->all();
        $validationSub = SubTeam::find()->where(['name' => $this->main_team])->all();

        foreach ($validationMain as $value) {
            if($value->getId() == $this->main_team_id)
            {
                foreach ($validationSub as $value2) {
                    if($value2->getId() == $this->main_team_id)
                    {
                        if($value2->getId() == $this->subTeamId)
                        {
                            return true;
                        }
                        elseif($value2->getGameId() == $this->game_id && $value2->getTournamentModeId() == $this->tournament_mode_id)
                        {
                            $this->addError($attribute, 'Sorry only one ' . $this->game . ' Team can Take this Name in ' . $this->tournament_mode );
                        }
                    }
                    else
                    {
                        if($value2->getGameId() == $this->game_id && $value2->getTournamentModeId() == $this->tournament_mode_id)
                        {
                            $this->addError($attribute, 'Sorry only one ' . $this->game . ' Team can Take this Name in ' . $this->tournament_mode );
                        }
                    }
                }
            }
        }

        return true;
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
        $team = MainTeam::findOne(['id' => $this->team_id]);

        /** Default informations */
        $team->name = $this->name;
        $team->headquater_id = $this->headquater_id;
        $team->language_id = $this->language_id;

        /** Management Informations */
        $team->owner_id = $this->owner_id;
        $team->deputy_id = $this->deputy_id;

        /** Team Informations */
        $team->short_code = (empty($this->short_code) ? '' : $this->short_code);
        $team->description = $this->description;

        /** Social Media Informations */
        $team->twitter_account = $this->twitter_account;
        $team->twitter_channel = $this->twitter_channel;
        $team->discord_server = $this->discord_server;
        
        try {
            $team->save();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            print_r($e);
            $transaction->rollBack();
            Alert::addError('Sub Team %s couldnt be saved', $team->name);
            //Alert::addError("user %s couldn't be saved" . $e->getMessage());
        }
        return false;
    }
}