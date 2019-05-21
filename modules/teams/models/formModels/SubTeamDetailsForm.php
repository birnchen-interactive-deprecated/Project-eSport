<?php

namespace app\modules\teams\models\formModels;

use app\components\FormModel;

use app\widgets\Alert;

use app\modules\user\models\User;
use app\modules\user\models\Language;
use app\modules\user\models\Nationality;

use app\modules\teams\models\SubTeam;

use app\modules\platformgames\models\Games;

use app\modules\tournaments\models\TournamentMode;

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
	public $main_team; 			
	public $subTeamId;			
	public $headquater_id;		
	public $language_id;		
	public $game_id;
	public $tournament_mode;

	/** Management Informations */
	public $captain_id;			
	public $deputy_id;			
	public $manager_id;			
	public $trainer_id;			

	/** Team Informations */
	public $isInTournament = false;		
	public $name;				
	public $short_code;			
	public $mixed = true;		
	public $main_short_code;	
	public $main_short_code_hidden;	
	public $description;		

	/** Social Media Informations */
	public $twitter_account;	
	public $twitter_channel;	
	public $discord_server;

    /**
     * SubTeamDetailsForm constructor.
     * @param $subTeamId
     */
    public function __construct($subTeamId)
    {
        $teamDetails = SubTeam::findOne(['id' => $subTeamId]);
        
        /** Language */
        $this->siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');

        /** Default informations */
        $this->main_team = $teamDetails->getMainTeam()->one()->getName();
        $this->subTeamId = $subTeamId;
        $this->headquater_id = $teamDetails->getHeadquaterId();
        $this->language_id = $teamDetails->getLanguageId();
        $this->game_id = $teamDetails->getGameId();
        $this->tournament_mode = $teamDetails->getTournamentMode()->one()->getName();

        /** Management Informations */
        $this->captain_id = $teamDetails->getTeamCaptainId();
        $this->deputy_id = $teamDetails->getTeamDeputyId();
        $this->manager_id = $teamDetails->getTeamManagerId();
        $this->trainer_id = $teamDetails->getTeamTrainerId();

        /** Team Informations */
        $this->name = $teamDetails->getTeamName();
        $this->short_code = $teamDetails->getTeamShortCode();
        $this->mixed = $teamDetails->getIsTeamShortCodeMixed();
        $this->main_short_code = $teamDetails->getMainTeam()->one()->getShortCode();
        $this->main_short_code_hidden = $teamDetails->getMainTeam()->one()->getShortCode();
        $this->description = $teamDetails->getTeamDescription();

        /** Social Media Informations */
        $this->twitter_account = $teamDetails->getTeamTwitterAccount();
        $this->twitter_channel = $teamDetails->getTeamTwitterChannel();
        $this->discord_server = $teamDetails->getTeamDiscordServer();  
    }


    /**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [
			[ 'language_id', 'exist', 'targetClass' => Language::className(), 'targetAttribute' => 'id' ],
        	[ 'headquater_id', 'exist',	'targetClass' => Nationality::className(), 'targetAttribute' => 'id' ],
			[ 'game_id', 'exist', 'targetClass' => Games::className(), 'targetAttribute' => 'id' ],
			[ ['captain_id', 'deputy_id', 'manager_id', 'trainer_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id' ],
			[ ['main_team', 'name', 'short_code', 'main_short_code', 'description'], 'string' ],
        	[ 'twitter_channel', 'string' ],
			[ 'discord_server', 'customUniqueDiscordValidator' ],
			[ 'twitter_account', 'customUniqueTwitterValidator'],
		];
	}

	/**
     * @return array the attribute labels
     */
    public function attributeLabels()
    {
    	$siteLanguage = Yii::$app->user->identity->getLanguage()->one();

        return [
        	'main_team' => \app\modules\teams\Module::t('teams','main_team', $siteLanguage->locale),
        	'headquater_id' => \app\modules\teams\Module::t('teams','headquater_id', $siteLanguage->locale),
        	'language_id' => \app\modules\teams\Module::t('teams','language_id', $siteLanguage->locale),
        	'captain_id' => \app\modules\teams\Module::t('teams','captain_id', $siteLanguage->locale),
        	'deputy_id' => \app\modules\teams\Module::t('teams','deputy_id', $siteLanguage->locale),
        	'manager_id' => \app\modules\teams\Module::t('teams','manager_id', $siteLanguage->locale),
        	'trainer_id' => \app\modules\teams\Module::t('teams','trainer_id', $siteLanguage->locale),
        	'name' => \app\modules\teams\Module::t('teams','name', $siteLanguage->locale),
        	'short_code' => \app\modules\teams\Module::t('teams','short_code', $siteLanguage->locale),
        	'mixed' => \app\modules\teams\Module::t('teams','mixed', $siteLanguage->locale),
        	'main_short_code' => \app\modules\teams\Module::t('teams','main_short_code', $siteLanguage->locale),
        	'description' => \app\modules\teams\Module::t('teams','description', $siteLanguage->locale),
        	'twitter_account' => \app\modules\teams\Module::t('teams','twitter_account', $siteLanguage->locale),
        	'twitter_channel' => \app\modules\teams\Module::t('teams','twitter_channel', $siteLanguage->locale),
        	'discord_server' => \app\modules\teams\Module::t('teams','discord_server', $siteLanguage->locale),
        ];
    }

	public function customUniqueDiscordValidator($attribute, $params)
    {
        return true;
    }

    public function customUniqueTwitterValidator($attribute, $params)
    {
        $validation = SubTeam::find()->where(['twitter_account' => $this->twitterAccount])->one();

        if(empty($validation))
            return true;
        else if (!empty($validation) && $validation->getId() == $subTeamId)
            return true;
        else
            $this->addError($attribute, 'Account ' . $this->twitterAccount . ' wird bereits verwendet' );
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
        $subTeam = SubTeam::findOne(['id' => $this->subTeamId]);

        /** Default informations */
        $subTeam->game_id = $this->game_id;
        $subTeam->headquater_id = $this->headquater_id;
        $subTeam->language_id = $this->language_id;

        /** Management Informations */
        $subTeam->captain_id = $this->captain_id;
        $subTeam->deputy_id = $this->deputy_id;
        $subTeam->manager_id = $this->manager_id;
        $subTeam->trainer_id = $this->trainer_id;

        /** Team Informations */
        $subTeam->name = $this->name;
        $subTeam->short_code = $this->short_code;
        $subTeam->mixed = $this->mixed;
        $subTeam->main_short_code = $this->main_short_code_hidden;
        $subTeam->description = $this->description;

        /** Social Media Informations */
        $subTeam->twitter_account = $this->twitter_account;
        $subTeam->twitter_channel = $this->twitter_channel;
        $subTeam->discord_server = $this->discord_server;
        
        try {
            $subTeam->save();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            print_r($e);
            $transaction->rollBack();
            Alert::addError('Sub Team %s couldnt be saved', $subTeam->name);
            //Alert::addError("user %s couldn't be saved" . $e->getMessage());
        }
        return false;
    }
}