<?php

/* @var $this yii\web\View *
 * @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var languageList array
 * @var gamesList array
 * @var nationalityList array
 * @var tournamentModeList array
 * @var playerList array
/* @var $model app\modules\teams\models\formModel\SubTeamDetailsForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

\app\modules\teams\assets\TeamsAsset::register($this);


?>
<div class="site-editSubTeamDetails">
	<?php $form = ActiveForm::begin([
        'id' => 'team-details-form',
        'options' => ['class' => 'form-vertical']
    ]); ?>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="panel panel-default panel-color">
                <div class="panel-heading panel-color">
                    <h3 class="panel-title panel-color"><?=\app\modules\teams\Module::t('teams','DetailsHead', $model->siteLanguage->locale)?></h3>
                </div>
                <div class="panel-body panel-color">

                    <div class="col-md-12">

                        <!-- Default informations -->
                        <?= $form->field($model, 'name')->textInput(["class" => 'form-control form-control-color','readonly'=> false]) ?>
                        <?= $form->field($model, 'headquater_id')->dropDownList($nationalityList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <?= $form->field($model, 'language_id')->dropDownList($languageList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <!-- Management Informations -->
                        <?= $form->field($model, 'owner_id')->dropDownList($playerList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <?= $form->field($model, 'deputy_id')->dropDownList($playerList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <!-- Team Informations -->
                        <?= $form->field($model, 'short_code')->textInput(["class" => 'form-control form-control-color', 'readonly'=> false]) ?>
                        <?= $form->field($model, 'description')->textInput(["class" => 'form-control form-control-color', 'readonly'=> false]) ?>

                        <!-- Social Media Informations -->
                        <?= $form->field($model, 'twitter_account')->textInput(["class" => 'form-control form-control-color','readonly'=> false]) ?>
                        <?= $form->field($model, 'twitter_channel')->textInput(["class" => 'form-control form-control-color', 'readonly'=> false]) ?>
                        <?= $form->field($model, 'discord_server')->textInput(["class" => 'form-control form-control-color','readonly'=> false]) ?>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="col-md-12">
        <?= Html::submitButton("Speichern", ['class' => 'btn mediumButton pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>