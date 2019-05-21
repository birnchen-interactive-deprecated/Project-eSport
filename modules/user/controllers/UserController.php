<?php

namespace app\modules\user\controllers;

use app\components\BaseController;
use app\modules\platformgames\models\Games;
use app\modules\platformgames\models\Platforms;
use app\modules\platformgames\models\UserGames;
use app\modules\user\models\formModels\LoginForm;
use app\modules\user\models\formModels\ProfilePicForm;
use app\modules\user\models\formModels\RegisterForm;
use app\modules\user\models\formModels\UserDetailsForm;
use app\modules\user\models\formModels\UserGameForm;

use app\modules\user\models\Gender;
use app\modules\user\models\Language;
use app\modules\user\models\Nationality;
use app\modules\user\models\User;

use app\widgets\Alert;
use DateTime;
use Yii;

use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class UserController
 *
 * @package app\modules\user\controllers
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
        $siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');

        /** @var User $user */
        $user = User::findIdentity($id);

        /** @var ProfilePicForm $profilePicModel */
        $profilePicModel = new ProfilePicForm(ProfilePicForm::SCENARIO_USER);
        $profilePicModel->id = $id;


        if ($profilePicModel->load(Yii::$app->request->post())) {
            $profilePicModel->file = UploadedFile::getInstance($profilePicModel, 'file');
            if ($profilePicModel->validate()) {
                $profilePicModel->save();
            }
        }

        /** @var $userInfo array */
        $userInfo = [
            'isMySelfe' => $isMySelfe,
            'memberSince' => DateTime::createFromFormat('Y-m-d H:i:s', $user->dt_created)->format('d.m.y'),
            'age' => (new DateTime($user->birthday))->diff(new DateTime())->y,
            'gender' => $user->getGender()->one(),
            'language' => $user->getLanguage()->one(),
            'languageImg' => Yii::$app->HelperClass->checkImage('/images/language/', (($user->getLanguageId() == 1) ? 1 : 2)),
            'nationality' => $user->getNationality()->one(), /** @todo prüfen wegen gender (Männlich/Weiblich/Divers) */
            'nationalityImg' => Yii::$app->HelperClass->checkImage('/images/nationality/', $user->getNationalityId()),
            'playerImage' => Yii::$app->HelperClass->checkImage('/images/userAvatar/', $user->getId()),
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
                'gameImg' => Yii::$app->HelperClass->checkImage('/images/gameLogos/', $userGame->getGameId()),
                'platform' => Yii::$app->HelperClass->checkImage('/images/platforms/', $userGame->getPlatformId()),
                'playerId' => $userGame->getPlayerId(),
                'visible' => $userGame->getIsVisible()
            ];
        }

        usort($games, function ($a, $b) {
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
                'siteLanguage' => $siteLanguage,
            ]);
    }

    public function actionEditDetails($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity == null && Yii::$app->user->identity->getId() != $id) {
            return $this->goHome();
        }

        /** @var User $user */
        $user = User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
        $model = new UserDetailsForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            $this->redirect("details?id=" . Yii::$app->user->identity->getId());
        }

        /** Language */
        $model->siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');

        /** Default informations */
        $model->username = $user->getUsername();
        $model->email = $user->getEmail();
        $model->birthday = Yii::$app->formatter->asDate($user->getBirthday(), 'dd.MM.yyyy');
        $model->genderId = $user->getGenderId();
        $model->languageId = $user->getLanguageId();
        $model->nationalityId = $user->getNationalityId();

        /** Personal user Informations */
        $model->preName = $user->getPreName();
        $model->lastName = $user->getLastName();
        $model->zipCode = $user->getZipCode();
        $model->city = $user->getCity();
        $model->street = $user->getStreet();

        /** Social media informations */
        $model->twitterAccount = $user->getTwitterAccount();
        $model->twitterChannels = $user->getTwitterChannels();
        $model->discordName = $user->getDiscordName();
        $model->discordServer = $user->getDiscordServer();

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
            $nationalityList[$nationality->getId()] = $nationality->getName();
        }

        return $this->render('editDetails',
            [
                'id' => $id,
                'genderList' => $genderList,
                'languageList' => $languageList,
                'nationalityList' => $nationalityList,
                'model' => $model
            ]);
    }

    public function actionAddGameId($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity == null && Yii::$app->user->identity->getId() != $id) {
            return $this->goHome();
        }

        $model = new UserGameForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $this->redirect("details?id=" . Yii::$app->user->identity->getId());
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
                'model' => $model
            ]);
    }

    public function actionToggleVisibility($gameId, $platformId)
    {
        $model = UserGames::find()->where(['game_id' => $gameId, 'platform_id' => $platformId, 'user_id' => Yii::$app->user->identity->getId()])->one();

        $model->visible = !$model->visible;
        $model->save();

        $gameName = Games::find()->where(['id' => $gameId])->one()->getName();

        Alert::addSuccess('Changed Visibility for ' . $gameName . ' from ' . (($model->visible)? 'invisible' : 'visible') . ' to ' . (($model->visible)? 'visible' : 'invisible'));
        //Alert::addError("Pierre ist doof"); 
        //Alert::addInfo("Pierre ist doof"); 

        return $this->redirect("details?id=" . Yii::$app->user->identity->getId());
    }
}