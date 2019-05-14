<?php

namespace app\modules\user\models\formModels;

use app\components\FormModel;



use Yii;
use yii\db\Exception;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class UserDetailsForm extends FormModel
{
	public $username;
    public $email;
    public $birthday;
    public $genderId;
    public $languageId;
    public $nationalityId;

}