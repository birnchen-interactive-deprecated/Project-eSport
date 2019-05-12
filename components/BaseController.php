<?php

namespace app\components;

use app\modules\tariff\models\Parameter;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{

    /**
     * Checks if a password change is required. If yes, the user will get redirected to the password change site until he changes his password.
     *
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     * @throws \Throwable
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!Yii::$app->user->isGuest && Yii::$app->user->getIdentity()->is_password_change_required == 1 && Yii::$app->controller->action->id !== 'password-change') {
            return $this->redirect(['/site/password-change']);
        }

        return true;
    }
}