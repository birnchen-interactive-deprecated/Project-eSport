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
use app\modules\teams\models\MainTeamMember;
use app\modules\teams\models\SubTeam;
use app\modules\teams\models\SubTeamMember;

use app\modules\user\models\Language;
use app\modules\user\models\Nationality;

use app\modules\platformgames\models\Games;

use app\modules\tournaments\models\TournamentMode;

use app\modules\user\models\formModels\ProfilePicForm;

use app\modules\user\models\User;

use app\modules\teams\models\formModels\SubTeamDetailsForm;
use app\modules\teams\models\formModels\TeamDetailsForm;

use app\widgets\Alert;

use DateTime;

use Yii;
use yii\web\UploadedFile;
use yii\filters\AccessControl;


class TeamsController extends BaseController
{
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
            'isDeputy' => (Yii::$app->user->identity != null && Yii::$app->user->identity->getId() == $teamDetails->deputy_id) ? true : false,
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

        $playerInfo = MainTeam::findOne(['id' => $teamDetails->getMainTeamId()])->getInvitableMembers($teamDetails->getTournamentModeId(),$teamDetails->getId(), $teamDetails->getGameId());

        return $this->render('subTeamDetails',
            [
                'profilePicModel' => $profilePicModel,
                'teamDetails' => $teamDetails,
                'teamInfo' => $teamInfo,
                'playerInfo' => $playerInfo
            ]);
    }

    public function actionEditDetails($id, $isSub = false)
    {
        $teamDetails = ($isSub) ? SubTeam::findOne(['id' => $id]) : MainTeam::findOne(['id' => $id]);

        if (Yii::$app->user->isGuest || Yii::$app->user->identity == null) {
            return $this->goHome();
        }

        if(Yii::$app->user->identity->getId() != (($isSub)? SubTeam::findOne(['id' => $id])->getTeamCaptainId() : MainTeam::findOne(['id' => $id])->getOwnerId())
            && Yii::$app->user->identity->getId() != (($isSub) ? SubTeam::findOne(['id' => $id])->getTeamDeputyId() : MainTeam::findOne(['id' => $id])->getDeputyId()))
        {
            return $this->goHome();
        }

        $model = ($isSub == true) ? SubTeamDetailsForm::getSubTeamForm($id) : TeamDetailsForm::getTeamForm($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            Alert::addSuccess('succesfully changed the Team details');
            return ($isSub == true) ?  $this->redirect("sub-team-details?id=" . $id) : $this->redirect("team-details?id=" . $id);
        }

        $languageList = [];
        foreach (Language::find()->all() as $language) {
            $languageList[$language->getId()] = $language->getName();
        }

        $nationalityList = [];
        foreach (Nationality::find()->all() as $nationality) {
            $nationalityList[$nationality->getId()] = $nationality->getName();
        }

        $gamesList = [];
        foreach (Games::find()->all() as $game) {
            $gamesList[$game->getId()] = $game->getName();
        }

        $tournamentModeList = [];
        foreach (TournamentMode::find()->all() as $tournamentMode) {
            $tournamentModeList[$tournamentMode->getId()] = $tournamentMode->getName();
        }

        $playerList = [];
        $mainteam = ($isSub) ?  SubTeam::findOne(['id' => $id])->getMainTeam()->one() : MainTeam::findOne(['id' => $id]);
        $members = $mainteam->getTeamMemberWithOwner();

        foreach ($members as $teamMember) {
            $playerList[$teamMember->getId()] = $teamMember->getUsername();
        }


        return $this->render((($isSub) ? 'editSubTeamDetails' : 'editDetails'),
            [
                'id' => $id,
                'languageList' => $languageList,
                'nationalityList' => $nationalityList,
                'playerList' => $playerList,
                'gamesList' => $gamesList,
                'tournamentModeList' => $tournamentModeList,
                'model' => $model
            ]);
    }

    public function actionAddSubTeam($teamId)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity == null) {
            return $this->goHome();
        }

        if(Yii::$app->user->identity->getId() != MainTeam::findOne(['id' => $teamId])->getOwnerId()
            && Yii::$app->user->identity->getId() != MainTeam::findOne(['id' => $teamId])->getDeputyId())
        {
            return $this->goHome();
        }

        $model = new SubTeam();

        $model->main_team_id = $teamId;
        $model->game_id = 1;
        $model->tournament_mode_id = 1;
        $model->headquater_id = MainTeam::findOne(['id' => $teamId])->getHeadquaterId();
        $model->language_id = MainTeam::findOne(['id' => $teamId])->getLanguageId();
        $model->captain_id = Yii::$app->user->identity->getId();
        $model->name = Yii::$app->user->identity->username . '\'s new Sub Team';
        $model->description = 'New team created by PeSp';

        $model->save();


        Alert::addSuccess('Sub Team created');

        return $this->redirect('edit-details?id=' . SubTeam::findOne(['main_team_id' => $teamId, 'name' => $model->name])->getId() . '&isSub=1');
    }

    public function actionDeleteMember($teamId, $userId, $isSub = false)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity == null) {
            return $this->goHome();
        }

        if(Yii::$app->user->identity->getId() != (($isSub)? SubTeam::findOne(['id' => $teamId])->getTeamCaptainId() : MainTeam::findOne(['id' => $teamId])->getOwnerId())
            && Yii::$app->user->identity->getId() != (($isSub) ? SubTeam::findOne(['id' => $teamId])->getTeamDeputyId() : MainTeam::findOne(['id' => $teamId])->getDeputyId()))
        {
            return $this->goHome();
        }

        $model = null;

        if($isSub)
        {
            $model = SubTeamMember::find()->where(['user_id' => $userId, 'sub_team_id' => $teamId])->one();

            if($model != null)
            {
                $model->delete();

                Alert::addSuccess('User ' . $model->getUser()->one()->getUsername() . ' deleted from ' . $model->getSubTeam()->one()->getTournamentMode()->one()->getName() . ' Sub Team '. $model->getSubTeam()->one()->getTeamName());

                //Alert::addError("Pierre ist doof"); 
                //Alert::addInfo("Pierre ist doof"); 

                return $this->redirect("sub-team-details?id=" . $teamId);
            }
            
            Alert::addError('User '. User::findIdentity($userId)->getUsername() .' does not exist in Team ' . SubTeam::findOne(['id' => $teamId])->getTeamName());

            return $this->redirect("sub-team-details?id=" . $teamId);    
        }
        else
        {
            $model = MainTeamMember::find()->where(['user_id' => $userId, 'main_team_id' => $teamId])->one();

            if($model != null)
            {
                $deputyModel = MainTeam::find()->where(['deputy_id' => $userId, 'id' => $teamId])->one();

                $subTeamModel = $model->getMainTeam()->one()->getSubTeams();   

                foreach ($subTeamModel as $value) {
                    if($value->getTeamDeputyId() == $userId)
                    {
                        $value->deputy_id = null;
                    }

                    if($value->getTeamTrainerId() == $userId)
                    {
                        $value->trainer_id = null;
                    }

                    if($value->getTeamManagerId() == $userId)
                    {
                        $value->manager_id = null;
                    }
                    if($value->getTeamCaptainId() == $userId)
                    {
                        $value->captain_id = Yii::$app->user->identity->getId();
                    }

                    $subTeamMember = SubTeamMember::find()->where(['user_id' => $userId, 'sub_team_id' => $value->getId()])->one();

                    $value->save();

                    if($subTeamMember != null)
                        $subTeamMember->delete();
                }

                if($deputyModel != null)
                {
                    $deputyModel->deputy_id = null;
                    $deputyModel->save();
                }
                

                $model->delete();

                Alert::addSuccess('User ' . $model->getUser()->one()->getUsername() . ' deleted from Main Team '. $model->getMainTeam()->one()->getName() . ' with all rights and memberships in Sub Teams');

                return $this->redirect("team-details?id=" . $teamId);
            }
            else
            {
                Alert::addError('User '. User::findIdentity($userId)->getUsername() .' does not exist in Team ' . MainTeam::findOne(['id' => $teamId])->getName() . ' or is Team Owner');

                return $this->redirect("team-details?id=" . $teamId);
            }
        }        
    }

    public function actionAddMemberToTeam($teamId, $userId, $sub)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity == null) {
            return $this->goHome();
        }

        if(Yii::$app->user->identity->getId() != SubTeam::findOne(['id' => $teamId])->getTeamCaptainId() 
            && Yii::$app->user->identity->getId() != SubTeam::findOne(['id' => $teamId])->getTeamDeputyId())
        {
            return $this->goHome();
        }

        $model = new SubTeamMember();

        $model->user_id = $userId;
        $model->sub_team_id = $teamId;
        $model->is_sub = $sub;

        $model->save();

        Alert::addSuccess('User Added');
        
        return $this->redirect("sub-team-details?id=" . $teamId);

    }

    public function actionSetMemberSubstitution($subTeamId, $userId)
    {
        $model = null;
        $model = SubTeamMember::find()->where(['user_id' => $userId, 'sub_team_id' => $subTeamId])->one();

        if($model != null)
        {
            $model->is_sub = !$model->is_sub;
            $model->save();

            Alert::addSuccess('User ' . $model->getUser()->one()->getUsername() . ' set from ' . (($model->is_sub) ? 'Main Player' : 'Substitude') . ' to '. (($model->is_sub) ? 'Substitude' : 'Main Player'));

            //Alert::addError("Pierre ist doof"); 
            //Alert::addInfo("Pierre ist doof"); 

            return $this->redirect("sub-team-details?id=" . $subTeamId);
        }
        else
        {
            Alert::addError('User '. User::findIdentity($userId)->getUsername() .' does not exist in Team ' . SubTeam::findOne(['id' => $subTeamId])->getTeamName());

            return $this->redirect("sub-team-details?id=" . $subTeamId);
        }       
    }
}