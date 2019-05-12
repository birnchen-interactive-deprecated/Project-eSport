<?php

namespace app\modules\company\controllers;

use app\components\BaseController;
use yii\filters\AccessControl;

/**
 * Class CompanyController
 *
 * @package app\modules\company\controllers
 */
class CompanyController extends BaseController
{
    /**
     * Access Controll
     * ka was es macht aber es blockt nicht eingeloggte user
     *
     * @inheritdoc
     */
    //public function behaviors()
    //{
    //    return [
    //        'access' => [
    //            'class' => AccessControl::className(),
    //            'rules' => [
    //                [
    //                    'allow' => true,
    //                    'roles' => ['@'],
    //                ]
    //            ]
    //        ]
    //    ];
    //}

    /**
     * Impressum
     *
     * @return string
     */
    public function actionImprint()
    {
        return $this->render('imprint');
    }

    /**
     * AGB
     *
     * @return string
     */
    public function actionGtc()
    {
        return $this->render('gtc');
    }

    /**
     * Datenschutz
     *
     * @return string
     */
    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

    /**
     * Aktuell ausgeschriebene Jobs
     *
     * @return string
     */
    public function actionJobs()
    {
        return $this->render('jobs');
    }
}