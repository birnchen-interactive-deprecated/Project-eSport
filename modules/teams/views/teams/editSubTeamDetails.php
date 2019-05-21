<?php

/* @var $this yii\web\View *
 * @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var genderList array
 * @var languageList array
 * @var nationalityList array
/* @var $model app\modules\teams\models\formModel\SubTeamDetailsForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

\app\modules\teams\assets\TeamsAsset::register($this);


?>
<div class="site-editSubTeamDetails">
    <?php $form = ActiveForm::begin([
        'id' => 'sub-team-details-form',
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

                        <!-- Default Informations -->
                        <?= $form->field($model, 'name')->textInput(["class" => 'form-control form-control-color','readonly'=> true]) ?>
                        <?= $form->field($model, 'short_code')->textInput(["class" => 'form-control form-control-color', 'readonly'=> false]) ?>

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