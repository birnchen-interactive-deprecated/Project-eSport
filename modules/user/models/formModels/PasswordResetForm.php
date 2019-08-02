<?php
/**
 * Created by PhpStorm.
 * User: Wenk
 * Date: 14.01.2019
 * Time: 12:35
 */

namespace app\models;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;

class PasswordResetForm extends Model
{
    public $username;
    public $email;

    public function rules()
    {
        return [
            // username and email are required
            [
                ['username', 'email'],
                'required'
            ],
            // username exist
            [
                'username',
                'exist',
                'targetClass' => User::className(),
                'targetAttribute' => 'username'
            ],
            // email is valid to username
            [
                'email',
                'emailIsValidToUser'
            ]
        ];
    }

    /**
     * Validate that the user has the email
     * @param $attribute
     * @param $params
     */
    public function emailIsValidToUser($attribute, $params)
    {
        $user = User::find()->where(['and', ['username' => $this->username], ['email' => $this->email]])->one();
        if (!$user) {
            $this->addError($attribute, Yii::t('app', 'Email do not pass to user'));
        }
    }
}