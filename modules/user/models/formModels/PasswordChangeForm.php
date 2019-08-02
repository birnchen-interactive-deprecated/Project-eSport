<?php
/**
 * Created by PhpStorm.
 * User: Wenk
 * Date: 23.05.2018
 * Time: 12:49
 */

namespace app\models;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * PasswordChangeForm is the model behind the password change form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class PasswordChangeForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $newPasswordRepeat;

    private $user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // oldPassword, newPassword and newPasswordRepeat are required
            [
                ['oldPassword', 'newPassword', 'newPasswordRepeat'],
                'required'
            ],
            // new password shouldn't be smaller then 6 signs
            [
                ['newPassword', 'newPasswordRepeat'],
                'string',
                'min' => 6,
            ],
            // oldPassword is validated by validatePassword()
            [
                'oldPassword',
                'validateOldPassword'
            ],
            // check if the new password is the same as the repeated one
            [
                'newPasswordRepeat',
                'compare',
                'compareAttribute' => 'newPassword'
            ],
            //check if the new password is not the same as the old one
            [
                'newPassword',
                'compare',
                'compareAttribute' => 'oldPassword',
                'operator' => '!=='
            ],
            [
                ['newPassword', 'newPasswordRepeat'],
                'validatePassword',
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Altes Passwort',
            'newPassword' => 'Neues Passwort',
            'newPasswordRepeat' => 'Neues Passwort wiederholen'
        ];
    }

    /**
     * Validates if the given password contains at least 1 special char, at least 1 number and at least 6 chars
     *
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        $validatePassword = preg_match('/^.*(?=.{6,})(?=.*[!$%&=?*-:;.,+~@_])(?=.*[0-9])(?=.*[a-z]).*$/', $this->newPassword);
        if (!$validatePassword) {
            $this->addError($attribute, Yii::t('app','The password needs to have..'));
        }
    }

    /**
     * Validates the old password.
     * This method serves as the inline validation for the old password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     * @throws \Throwable
     */
    public function validateOldPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->oldPassword)) {
                $this->addError($attribute, Yii::t('app', 'incorrect login'));
            }
        }
    }

    /**
     * Finds user
     *
     * @return User|null
     * @throws \Throwable
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = Yii::$app->user->getIdentity();
        }

        return $this->user;
    }

    /**
     * Saves the new password and sets the flag back
     */
    public function saveNewPassword()
    {
        $user = $this->getUser();
        $user->setPassword($this->newPassword);
        $user->is_password_change_required = 0;
        $user->save();

        return true;
    }
}