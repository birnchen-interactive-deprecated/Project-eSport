<?php

namespace app\modules\user\models\formModels;

use app\components\FormModel;
use app\widgets\Alert;

use app\modules\user\models\User;
use app\modules\user\models\Gender;
use app\modules\user\models\Language;
use app\modules\user\models\Nationality;

use Yii;
use yii\db\Exception;
use yii\db\Expression;

class RegisterForm extends FormModel
{
	public $username;
	public $email;
	public $password;
	public $passwordRepeate;
	public $genderId;
	public $languageId;
	public $nationalityId;
	public $birthday;

	/**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [
			[
            	['username', 'email', 'password', 'passwordRepeate', 'genderId', 'languageId', 'nationalityId'],
            	'required',
        	],
        	[
            	['password', 'passwordRepeate'],
            	'string',
            	'min' => 6,
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
        	[
            	'nationalityId',
        		'exist',
            	'targetClass' => Nationality::className(),
            	'targetAttribute' => 'id'
        	],
        	[
        		'username',
            	'unique',
        	    'targetClass' => User::className(),
    	        'targetAttribute' => 'username',
    	        'message' => Yii::t('app', 'usernameUsed')
        	],
        	[
            	'email',
            	'email',
        	],
        	[
            	'passwordRepeate',
            	'compare',
            	'compareAttribute' => 'password'
        	],
        	[
            	['password', 'passwordRepeate'],
        	    'validatePassword',
    	    ]
		];
	}

	/**
     * @return array the attribute labels
     */
    public function attributeLabels()
    {
        return [
        	'username' => \app\modules\user\Module::t('register','username'),
            'password' => \app\modules\user\Module::t('register','password'),
            'passwordRepeate' => \app\modules\user\Module::t('register','passwordRepeate'),
            'email' => \app\modules\user\Module::t('register','email'),
            'birthday' => \app\modules\user\Module::t('register','birthday'),
            'genderId' => \app\modules\user\Module::t('register','genderId'),
            'languageId' => \app\modules\user\Module::t('register','languageId'),
            'nationalityId' => \app\modules\user\Module::t('register','nationalityId'),
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
        $user = new User();
        $user->dt_created = new Expression("now");
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->username = $this->username;
        $user->birthday =  Yii::$app->formatter->asDate($this->birthday, 'yyyy-MM-dd');
        $user->gender_id = $this->genderId;
        $user->language_id = $this->languageId;
        $user->nationality_id = $this->nationalityId;
        $user->email = $this->email;

        try {
            $user->save();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            print_r($e->getMessage());
            $transaction->rollBack();
            //Alert::addError(Module::t("general", "user %s couldn't be saved"), $user->getUsername());
        }
        return false;
    }

}