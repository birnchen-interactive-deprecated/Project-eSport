<?php

namespace app\modules\user\models\formModels;

use app\components\FormModel;
use Yii;

class UserTeamForm extends FormModel
{
	public $teamId;

	/**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                'teamId',
                'required'
            ]
        ];
    }
}