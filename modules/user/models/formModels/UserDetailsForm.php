<?php

namespace app\modules\user\models\formModels;

use app\components\FormModel;

use app\widgets\Alert;

use app\modules\user\models\User;
use app\modules\user\models\Gender;
use app\modules\user\models\Language;
use app\modules\user\models\Nationality;

use Yii;
use yii\db\Expression;
use yii\db\Exception;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class UserDetailsForm extends FormModel
{
	public $siteLanguage;

	/** Default informations */
	public $username;
    public $email;
    public $birthday;
    public $genderId;
    public $languageId;
    public $nationalityId;

    /** Personal user Informations */
    public $preName;
    public $lastName;
    public $zipCode;
    public $city;
    public $street;

    /** Social media informations */
    public $twitterAccount;
    public $twitterChannels;
    public $discordName;
    public $discordServer;

    /**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [
			[
            	['username', 'email', 'birthday', 'genderId', 'languageId', 'nationalityId'],
            	'required',
        	],
        	[
            	'birthday',
            	'date'
        	],
        	[
        		'genderId',
        		'exist',
        		'targetClass' => Gender::className(),
    			'targetAttribute' => 'id'
        	],
        	[
            	'languageId',
            	'exist',
        		'targetClass' => Language::className(),
        		'targetAttribute' => 'id'
        	],
        	[ 'nationalityId', 'exist',	'targetClass' => Nationality::className(), 'targetAttribute' => 'id' ],
        	[ 
                ['preName', 'lastName', 'zipCode', 'city', 'street', 'twitterChannels', 'discordServer'],
                'string'
            ],
            [ 
                'discordName',
                'customUniqueDiscordValidator'
            ],
            [ 
                'twitterAccount',
                'customUniqueTwitterValidator',
            ],
        	[ 'email', 'email' ],
		];
	}

	/**
     * @return array the attribute labels
     */
    public function attributeLabels()
    {
    	$siteLanguage = Yii::$app->user->identity->getLanguage()->one();

        return [
        	'username' => \app\modules\user\Module::t('userDetails','username', $siteLanguage->locale),
            'email' => \app\modules\user\Module::t('userDetails','email', $siteLanguage->locale),
            'birthday' => \app\modules\user\Module::t('userDetails','birthday', $siteLanguage->locale),
            'genderId' => \app\modules\user\Module::t('userDetails','genderId', $siteLanguage->locale),
            'languageId' => \app\modules\user\Module::t('userDetails','languageId', $siteLanguage->locale),
            'nationalityId' => \app\modules\user\Module::t('userDetails','nationalityId', $siteLanguage->locale),

            /** Personal user Informations */
    		'preName' => \app\modules\user\Module::t('userDetails','preName', $siteLanguage->locale),
    		'lastName' => \app\modules\user\Module::t('userDetails','lastName', $siteLanguage->locale),
    		'zipCode' => \app\modules\user\Module::t('userDetails','zipCode', $siteLanguage->locale),
    		'city' => \app\modules\user\Module::t('userDetails','city', $siteLanguage->locale),
    		'street' => \app\modules\user\Module::t('userDetails','street', $siteLanguage->locale),

    		/** Social media informations */
    		'twitterAccount' => \app\modules\user\Module::t('userDetails','twitterAccount', $siteLanguage->locale),
    		'twitterChannels' => \app\modules\user\Module::t('userDetails','twitterChannels', $siteLanguage->locale),
    		'discordName' => \app\modules\user\Module::t('userDetails','discordName', $siteLanguage->locale),
    		'discordServer' => \app\modules\user\Module::t('userDetails','discordServer', $siteLanguage->locale),
        ];
    }

    /**
     * Validates if the given password contains at least 1 special char, at least 1 number and at least 6 chars
     *
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validatePassword($attribute, $params)
    {
        /*$validatePassword = preg_match('/^.*(?=.{6,})(?=.*[!$%&=?*-:;.,+~@_])(?=.*[0-9])(?=.*[a-z]).*$/', $this->password);

        if (!$validatePassword) {
            $this->addError($attribute, Yii::t('app', 'The password needs to have..'));
        }*/

        return true;
    }

    public function customUniqueDiscordValidator($attribute, $params)
    {
        //$this->addError($attribute, $attribute . ' | ' . $params['targetAttribute'] . ' | ' . $params['value'] . ' | ' . $params['targetClass']);

        $validation = User::find()->where(['discord_id' => $this->discordName])->one();

        if(empty($validation))
            return true;
        else if (!empty($validation) && $validation->getId() == Yii::$app->user->identity->getId())
            return true;
        else
            $this->addError($attribute, 'Account ' . $this->discordName . ' wird bereits verwendet' );
    }

    public function customUniqueTwitterValidator($attribute, $params)
    {
        //$this->addError($attribute, $attribute . ' | ' . $this->twitterAccount);

        $validation = User::find()->where(['twitter_account' => $this->twitterAccount])->one();

        print_r($validation);

        if(empty($validation))
            return true;
        else if (!empty($validation) && $validation->getId() == Yii::$app->user->identity->getId())
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
        $user = User::findIdentity(Yii::$app->user->identity->getId());
        /** Changeable Base Informations */
        $user->email = $this->email;
        $user->birthday =  Yii::$app->formatter->asDate($this->birthday, 'yyyy-MM-dd');
        $user->gender_id = $this->genderId;
        $user->language_id = $this->languageId;
        $user->nationality_id = $this->nationalityId;
        $user->dt_updated = new Expression("now");

        /** Personal Informations */
        $user->pre_name = (empty($user->pre_name)? $this->preName : $user->pre_name);
    	$user->last_name = (empty($user->last_name)? $this->lastName : $user->last_name);
    	$user->zip_code = (empty($user->zip_code)? $this->zipCode : $user->zip_code);
    	$user->city = (empty($user->city)? $this->city : $user->city);
    	$user->street = (empty($user->street)? $this->street : $user->street);

    	/** Social Media */
        $user->twitter_account = $this->twitterAccount;
    	$user->twitter_channel = $this->twitterChannels;
    	$user->discord_id = (empty($user->discord_id)? $this->discordName : $user->getDiscordName());
    	$user->discord_server = $this->discordServer;

        try {
            $user->save();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            print_r($e);
            $transaction->rollBack();
            Alert::addError('user %s couldnt be saved', $user->username);
            //Alert::addError("user %s couldn't be saved" . $e->getMessage());
        }
        return false;
    }
}