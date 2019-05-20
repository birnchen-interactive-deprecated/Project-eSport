<?php

namespace app\modules\events\controllers;

use app\components\BaseController;
use yii\filters\AccessControl;

/**
 * Class CompanyController
 *
 * @package app\modules\events\controllers
 */
class EventsController extends BaseController
{
    /**
     * Impressum
     *
     * @return string
     */
    public function actionOverview()
    {
        return $this->render('overview');
    }
}