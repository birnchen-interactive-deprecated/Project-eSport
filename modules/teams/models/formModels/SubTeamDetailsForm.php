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
 * SubTeamDetailForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SubTeamDetailsForm extends FormModel
{
	public $siteLanguage;

	/** Default informations */
	public $main_team_id;
	public $headquater_id;
	public $language_id;

	/** Management Informations */
	public $captain_id;
	public $deputy_id;
	public $manager_id;
	public $trainer_id;

	/** Team Informations */
	public $name;
	public $short_code;
	public $mixed;
	public $main_short_code;
	public $description;

	/** Social Media Informations */
	public $twitter_account;
	public $twitter_channel;
	public $discord_server;

	/**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [

			[ 
                'twitterAccount',
                'customUniqueTwitterValidator',
            ],
		];
	}

	/**
     * @return array the attribute labels
     */
    public function attributeLabels()
    {
    	$siteLanguage = Yii::$app->user->identity->getLanguage()->one();

        return [
        	'name' => \app\modules\teams\Module::t('teams','teamName', $siteLanguage->locale),
        ];
    }

	public function customUniqueDiscordValidator($attribute, $params)
    {
        return true;
    }

    public function customUniqueTwitterValidator($attribute, $params)
    {
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
        $subTeam = SubTeam::findOne(['id' => $id]);
        
        return true;
    }
}