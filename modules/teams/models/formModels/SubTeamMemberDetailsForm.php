<?php

namespace app\modules\teams\models\formModels;

use app\components\FormModel;

use app\widgets\Alert;

use app\modules\user\models\User;

use app\modules\teams\models\SubTeam;
use app\modules\teams\models\SubTeamMember;

use Yii;
use yii\db\Expression;
use yii\db\Exception;

/**
 * SubTeamDetailForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SubTeamMemberDetailsForm extends FormModel
{
	public $siteLanguage;

	/** Base informations */
	public $membersList = [];
	public $mainPlayer_1;
	public $mainPlayer_2;
	public $mainPlayer_3;
	public $subPlayer_1;
	public $subPlayer_2;

	/** tournament mode */
	public $maxMainPlayer;

	/**
     * SubTeamDetailsForm constructor.
     * @param $subTeamId
     * @return SubTeamDetailsForm
     */
    public static function getSubTeamMemberForm($subTeamId)
    {
        $teamDetails = SubTeam::findOne(['id' => $subTeamId]);
        $model = new SubTeamMemberDetailsForm();
        /** Language */
        $model->siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');

        $tournamentMode = $teamDetails->getTournamentMode()->one();
        $maxPlayers = $tournamentMode->getMaxPlayer();
        $substitudes = $tournamentMode->getSubPlayer();
        $model->maxMainPlayer = $tournamentMode->getMaxPlayer() - $tournamentMode->getSubPlayer();

        /** Get Main and Sub Players */
        $members = SubTeamMember::getSubTeamMembers($subTeamId);
        foreach ($members as $teamMember) {
            $model->membersList[$teamMember->getUserId()] = $teamMember->getUser()->one()->getUsername();
        }

        foreach ($members as $teamMember) {
        	if(!$teamMember->getIsSub())
	        	if($model->mainPlayer_1 == null)
	        		$model->mainPlayer_1 = $teamMember->getUser()->one()->getUsername();
	        	else if($model->mainPlayer_2 == null)
	        		$model->mainPlayer_2 = $teamMember->getUser()->one()->getUsername();
	        	else
	        		$model->mainPlayer_3 = $teamMember->getUser()->one()->getUsername();
        	else
        		if($model->subPlayer_1 == null)
	        		$model->subPlayer_1 = $teamMember->getUserId();
	        	else if($model->subPlayer_2 == null)
	        		$model->subPlayer_2 = $teamMember->getUserId();

        	//if(!$teamMember->getIsSub())
            	//$model->mainPlayer[$teamMember->getUserId()] = $teamMember->getUser()->one()->getUsername();
            //else
            	//$model->subPlayer[$teamMember->getUserId()] = $teamMember->getUser()->one()->getUsername();
        }

        /**  */





        return $model;
    }

    /**
     * @return array the attribute labels
     */
    public function attributeLabels()
    {
    	$siteLanguage = Yii::$app->user->identity->getLanguage()->one();

        return [
        	'mainPlayer' => \app\modules\teams\Module::t('teams','main_team', $siteLanguage->locale),
        ];
    }
}