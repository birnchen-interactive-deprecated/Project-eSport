<?php

namespace app\modules\user\controllers;

use app\components\BaseController;

use app\modules\user\models\formModels\ProfilePicForm;
use app\modules\user\models\formModels\LoginForm;
use app\modules\user\models\formModels\RegisterForm;

use app\modules\User\models\User;
use app\modules\user\models\Gender;
use app\modules\user\models\Language;
use app\modules\user\models\Nationality;

use app\modules\miscellaneous\HelperClass;

use DateTime;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

/**
 * Class UserController
 *
 * @package app\modules\userAccount\controllers
 */
class UserController extends BaseController
{
	/**
	 * @inheritdoc
	 */
	public function behavior()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['0'],
					]
				]
			]
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
	 * Display the user dashboard
	 *
	 * @return Response|string
	 * @throws \Exception
	 * @throws \Throvable
	 */
	public function actionIndex()
	{
		return $this->goHome();
		//return $this->redirect(array('index'));
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
        $model = new RegisterForm();

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

    public function actionDetails($id)
    {
        /** Check if User ID my own User ID */
        $isMySelfe = (Yii::$app->user->identity != null && Yii::$app->user->identity->getId() == $id) ? true : false;

        /** @var User $user */
        $user = User::findIdentity($id);

        /** @var ProfilePicForm $profilePicModel */
        $profilePicModel = new ProfilePicForm(ProfilePicForm::SCENARIO_USER);
        $profilePicModel->id = $id;
        

        if($profilePicModel->load(Yii::$app->request->post()))
        {
            $profilePicModel->file = UploadedFile::getInstance($profilePicModel, 'file');
            if($profilePicModel->validate())
            {
                $profilePicModel->save();
            }
        }

        /** @var $userInfo array */
        $userInfo = [
            'isMySelfe' => $isMySelfe,
            'memberSince' => DateTime::createFromFormat('Y-m-d H:i:s', $user->dt_created)->format('d.m.y'),
            'age' => (new DateTime($user->birthday))->diff(new DateTime())->y,
            'gender' => $user->getGender()->one(),
            'language' => ($isMySelfe)? $user->getLanguage()->one() : Language::findByLocale('en-US'),
            'nationality' => $user->getNationality()->one(), /** @todo prüfen wegen gender (Männlich/Weiblich/Divers) */
            'nationalityImg' => Yii::$app->helperClass->checkImage('/images/nationality/', $user->getNationalityId()),
            'playerImage' => helperClass::checkImage('/images/userAvatar/', $user->getId()),
        ];

        /** Get all Game Id's from the user */

        /** @var $userGames array */
        $userGames = $user->getGames()->all();

        /** @var $games array */
        $games = [];
        foreach ($userGames as $userGame) {
            $games[] = [
                'gameId' => $userGame->getGameId(),
                'platformId' => $userGame->getPlatformId(),
                'gameImg' => helperClass::checkImage('/images/gameLogos/', $userGame->getGameId()),
                'platform' => helperClass::checkImage('/images/platforms/', $userGame->getPlatformId()),
                'playerId' => $userGame->getPlayerId(),
                'visible' => $userGame->getIsVisible()
            ];
        }

        usort($games, function($a, $b) {
            return [$a['platformId'], $a['gameId']] <=> [$b['platformId'], $b['gameId']];
        });

        /** Get all Teams and Sub Teams from the user */
        $mainTeams = $user->getMainTeams();

        $subTeams = $user->getAllSubTeamsWithMembers();

        return $this->render('details',
            [
                'profilePicModel' => $profilePicModel,
                'model' => $user,
                'userInfo' => $userInfo,
                'games' => $games,
                'mainTeams' => $mainTeams,
                'subTeams' => $subTeams,
            ]);
    }
}