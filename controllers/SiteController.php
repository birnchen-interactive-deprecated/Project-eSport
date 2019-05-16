<?php

namespace app\controllers;

use app\components\BaseController;

use app\modules\user\models\LoginForm;
use app\modules\user\models\UserForm;

use app\modules\user\models\Gender;
use app\modules\user\models\Language;
use app\modules\user\models\Nationality;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\filters\VerbFilter;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $isGuest = (Yii::$app->user->isGuest) ? false : true;

         $twitterImg = Html::img(Yii::$app->HelperClass->checkImage('/images/socialMedia/', 'Twitter_Logo_Blue') . 'webp', ['height' => '49px', 'alt'=> 'twitter image', 'aria-label' => 'twitter image', 'onerror' => 'this.src=' . Yii::$app->HelperClass->checkImage('/images/socialMedia/', 'Twitter_Logo_Blue') . 'png']);

         $twitterLink = Html::a($twitterImg, 'https://twitter.com/esport_project', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'Follow us on twitter', 'label' => 'twitter']);

         $discordImg = Html::img(Yii::$app->HelperClass->checkImage('/images/socialMedia/', 'Discord-Logo-White') . 'webp', ['height' => '49px', 'alt'=> 'discord', 'aria-label' => 'discord', 'onerror' => 'this.src=' . Yii::$app->HelperClass->checkImage('/images/socialMedia/', 'Discord-Logo-White') . 'png']);

         $discordLink = Html::a($discordImg, 'https://discord.gg/f6NXNFy', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'Join our Discord Server']);



        $socialMedia = [
            'twitter' => $twitterLink,
            'discord' => $discordLink,
        ];

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $this->goHome();
        }

        $genderList = [];
        foreach (Gender::find()->all() as $gender) {
            $genderList[$gender->getId()] = $gender->getName();
        }

        $languageList = [];
        foreach (Language::find()->all() as $language) {
            $languageList[$language->getId()] = $language->getName();
        }

        $nationalityList = [];
        foreach (Nationality::find()->all() as $nationality) {
            $nationalityList[$nationality->getId()] = $nationality->getSynonymeM();
        }

        return $this->render('register',
            [
                "model" => $model,
                'genderList' => $genderList,
                'languageList' => $languageList,
                'nationalityList' => $nationalityList
            ]);
    }
}