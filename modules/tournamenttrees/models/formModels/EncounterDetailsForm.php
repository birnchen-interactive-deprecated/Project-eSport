<?php

namespace app\modules\tournamenttrees\models\formModels;

use app\components\FormModel;

use app\widgets\Alert;

use Yii;
use yii\db\Expression;
use yii\db\Exception;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class EncounterDetailsForm extends FormModel
{
	public $siteLanguage;

	public $winnerId;

	/**
     * SubTeamDetailsForm constructor.
     * @param $subTeamId
     * @return SubTeamDetailsForm
     */
    public static function getEncounterForm()
    {
        //$teamDetails = MainTeam::findOne(['id' => $teamId]);
        $model = new EncounterDetailsForm();
        /** Language */
        $model->siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');
        //$model->team_id = $teamId;

        /** Default informations */
        //$model->headquater_id = $teamDetails->getHeadquaterId();
        //$model->language_id = $teamDetails->getLanguageId();

        /** Management Informations */
        //$model->owner_id = $teamDetails->getOwnerId();
        //$model->deputy_id = $teamDetails->getDeputyId();

        /** Team Informations */
        //$model->name = $teamDetails->getName();
        //$model->short_code = $teamDetails->getShortCode();
        //$model->description = $teamDetails->getTeamDescription();

        /** Social Media Informations */
        //$model->twitter_account = $teamDetails->getTwitterAccount();
        //$model->twitter_channel = $teamDetails->getTwitterChannel();
        //$model->discord_server = $teamDetails->getDiscordServer();

        return $model;
    }

    /**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [
            [ 'name', 'string' ],
		];
	}

	/**
     * Creates a new user, or updates an existing one.
     *
     * @return boolean true, if the user was saved successfully
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\Exception
     */
    public function save()
    {
    	$transaction = Yii::$app->db->beginTransaction();
    	$encounter = null;


    	try {
            $encounter->save();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            print_r($e);
            $transaction->rollBack();
            Alert::addError('Sub Team %s couldnt be saved', $team->name);
            //Alert::addError("user %s couldn't be saved" . $e->getMessage());
        }
        return false;
    }
}