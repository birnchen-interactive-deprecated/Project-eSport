<?php

namespace app\modules\platformgames\controllers;

use Yii;

use app\components\BaseController;

use app\modules\platformgames\models\formModels\UserGameForm;

use app\modules\platformgames\models\Games;
use app\modules\platformgames\models\Platforms;

/**
 * Class PlatformgamesController
 *
 * @package app\modules\platformgames\controllers
 */
class PlatformgamesController extends BaseController
{
	public function actionAddGameId($id)
    {
    	if (Yii::$app->user->isGuest || Yii::$app->user->identity == null && Yii::$app->user->identity->getId() != $id) {
            return $this->goHome();
        }

    	$model = new UserGameForm;

    	if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $this->goHome();
        }

        $gamesList = [];
        foreach (Games::find()->all() as $games) {
            $gamesList[$games->getId()] = $games->getName();
        }

        $platformList = [];
        foreach (Platforms::find()->all() as $platforms) {
            $platformList[$platforms->getId()] = $platforms->getName();
        }

    	return $this->render('addGameId',
            [
                'id' => $id,
                'gamesList' => $gamesList,
                'platformList' => $platformList,
            ]);
    }
}