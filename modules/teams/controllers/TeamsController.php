<?php
/**
 * Created by PhpStorm.
 * User: Pierre Köhler
 * Date: 27.03.2019
 * Time: 09:49
 */

namespace app\modules\teams\controllers;

use app\components\BaseController;
use app\modules\teams\models\MainTeam;
use app\modules\teams\models\SubTeam;

use app\modules\user\models\formModels\ProfilePicForm;

use DateTime;

use Yii;
use yii\web\UploadedFile;
use yii\filters\AccessControl;


class TeamsController extends BaseController
{
    /**
     * Access Controll
     * ka was es macht aber es blockt nicht eingeloggt user
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
     * Main Team Details Page
     *
     * @param null $id
     * @return string
     * @throws \Exception
     */
    public function actionTeamDetails($id = null)
    {
        $teamDetails = MainTeam::findOne(['id' => $id]);
        $subTeams = $teamDetails->getSubTeamsGroupByTournamentMode();

        /** @var ProfilePicForm $profilePicModel */
        $profilePicModel = new ProfilePicForm(ProfilePicForm::SCENARIO_MAINTEAM);
        $profilePicModel->id = $id;

        if ($profilePicModel->load(Yii::$app->request->post())) {
            $profilePicModel->file = UploadedFile::getInstance($profilePicModel, 'file');
            if ($profilePicModel->validate()) {
                $profilePicModel->save();
            }
        }

        /* Get Register Date and Age */
        $memberDateTime = new DateTime('2019-03-01');

        /** @var $teamInfo array */
        $teamInfo = [
            'isOwner' => (Yii::$app->user->identity != null && Yii::$app->user->identity->getId() == $teamDetails->owner_id) ? true : false,
            //'memberSince' => DateTime::createFromFormat('d.m.y', $user->dt_created),
            'memberSince' => $memberDateTime->format('d.m.y'),
            'language' => $teamDetails->getHeadQuaterId(),
            //'nationality' => $teamDetails->getHeadQuarterId(),
            'nationalityImg' => Yii::getAlias("@web") . '/images/nationality/' . $teamDetails->getHeadQuaterId() . '.png',
            'teamImage' => Yii::getAlias("@web") . '/images/teams/mainTeams/' . $teamDetails->getId()
        ];

        /* Set Correct Image Path */
        if (!is_file($_SERVER['DOCUMENT_ROOT'] . $teamInfo['teamImage'] . '.webp')) {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] . $teamInfo['teamImage'] . '.png')) {
                $teamInfo['teamImage'] = Yii::getAlias("@web") . '/images/userAvatar/default';
            }
        }

        return $this->render('teamDetails',
            [
                'profilePicModel' => $profilePicModel,
                'teamDetails' => $teamDetails,
                'teamInfo' => $teamInfo,
                'subTeams' => $subTeams,
            ]);
    }

    /**
     * Sub Team Details Page
     *
     * @param null $id
     * @return string
     * @throws \Exception
     */
    public function actionSubTeamDetails($id = null)
    {
        $teamDetails = SubTeam::findOne(['id' => $id]);

        /** @var ProfilePicForm $profilePicModel */
        $profilePicModel = new ProfilePicForm(ProfilePicForm::SCENARIO_SUBTEAM);
        $profilePicModel->id = $id;

        if ($profilePicModel->load(Yii::$app->request->post())) {
            $profilePicModel->file = UploadedFile::getInstance($profilePicModel, 'file');
            if ($profilePicModel->validate()) {
                $profilePicModel->save();
            }
        }

        /* Get Register Date and Age */
        $memberDateTime = new DateTime('2019-03-01');

        /** @var $teamInfo array */
        $teamInfo = [
            'isOwner' => (Yii::$app->user->identity != null && Yii::$app->user->identity->getId() == $teamDetails->captain_id) ? true : false,
            'isDeputy' => (Yii::$app->user->identity != null && Yii::$app->user->identity->getId() == $teamDetails->deputy_id) ? true : false,
            //'memberSince' => DateTime::createFromFormat('d.m.y', $user->dt_created),
            'memberSince' => $memberDateTime->format('d.m.y'),
            //'language' => $teamDetails->getHeadQuarterId(),
            //'nationality' => $teamDetails->getHeadQuarterId(),
            //'nationalityImg' => Yii::getAlias("@web") . '/images/nationality/' . $teamDetails->getHeadQuarterId() . '.png',
            'teamImage' => Yii::getAlias("@web") . '/images/teams/subTeams/' . $teamDetails->getId()
        ];

        /* Set Correct Image Path */
        if (!is_file($_SERVER['DOCUMENT_ROOT'] . $teamInfo['teamImage'] . '.webp')) {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] . $teamInfo['teamImage'] . '.png')) {
                $teamInfo['teamImage'] = Yii::getAlias("@web") . '/images/userAvatar/default';
            }
        }


        return $this->render('subTeamDetails',
            [
                'profilePicModel' => $profilePicModel,
                'teamDetails' => $teamDetails,
                'teamInfo' => $teamInfo,
            ]);
    }

    public function actionChangeTeamDetails($id = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $teamDetails = MainTeam::findOne(['team_id' => $id]);
        $myID = Yii::$app->user->identity->getId();

        /** Check if owner ID my own User ID */
        if($teamDetails->getOwnerId() == $myID)
        $isMySelfe = (Yii::$app->user->identity != null && Yii::$app->user->identity->getId() == $id) ? true : false;

        return $this->render('changeTeamDetails',
            [

            ]);
    }
}