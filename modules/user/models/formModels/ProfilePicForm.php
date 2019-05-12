<?php

namespace app\modules\user\models\formModels;

use app\components\FormModel;
use Yii;

class ProfilePicForm extends FormModel
{
	const SCENARIO_USER = 'userAvatar';
	const SCENARIO_MAINTEAM = 'teams/mainTeams';
	const SCENARIO_SUBTEAM = 'teams/subTeams';

	public $id;
	public $file;

	public function scenarios()
	{
		return [
			ProfilePicForm::SCENARIO_USER => $this->attributes(),
            ProfilePicForm::SCENARIO_MAINTEAM => $this->attributes(),
            ProfilePicForm::SCENARIO_SUBTEAM => $this->attributes()
		];
	}

	/**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['file', 'id'],
                'required'
            ],
            [
                'file',
                'image',
                'extensions' => 'png',
                'maxSize' => 1024 * 1024 * 3
            ]
        ];
    }

    /**
     * Creates a new user, or updates an existing one.
     *
     * @return void true, if the user was saved successfully
     */
    public function save()
    {
        $docRoot = Yii::getAlias("@app") . '/web/images/' . $this->getScenario() . '/';

        $filePathPng = $docRoot . $this->id . '.png';
        $filePathWebp = $docRoot . $this->id . '.webp';

        if (!is_dir($docRoot)) {
            mkdir($docRoot, 0777, true);
        }

        $this->file->saveAs($filePathPng);

        // Buggy mit 7.0.33, sollte ab 7.1.x aufwärts laufen, wenn "WebP Support === true"
        // $im = imagecreatefrompng($filePathPng);
        // imagewebp($im, $filePathWebp);

        // Workaround
        $cmd = escapeshellcmd('cwebp ' . $filePathPng . ' -o ' . $filePathWebp);
        shell_exec($cmd);
    }
}