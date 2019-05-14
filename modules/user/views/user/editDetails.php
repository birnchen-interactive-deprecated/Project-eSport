<?php

/* @var $this yii\web\View *
 * @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var genderList array
 * @var languageList array
 * @var nationalityList array
/* @var $model app\modules\platformgames\models\formModel\UserGameForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use kartik\date\DatePicker;

\app\modules\user\assets\UserAsset::register($this);

?>
<div class="site-addGame">
	<?php $form = ActiveForm::begin([
        'id' => 'user-details-form',
        'options' => ['class' => 'form-vertical']
    ]); ?>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="panel panel-default panel-color">
                <div class="panel-heading panel-color">
                    <h3 class="panel-title panel-color"><?= \app\modules\user\Module::t('userDetails','DetailsHead', $model->siteLanguage->locale)?></h3>
                </div>
                <div class="panel-body panel-color">

                    <div class="col-md-12">

					    <!-- Default Informations -->
                        <?= $form->field($model, 'username')->textInput(["class" => 'form-control form-control-color','readonly'=> true]) ?>
                        <?= $form->field($model, 'email')->textInput(["class" => 'form-control form-control-color', 'readonly'=> true]) ?>

                        <?= $form->field($model, 'birthday')->widget(DatePicker::className(), [
					        'options' => [
					            'class' => 'form-control form-control-color'
					        ],
					        'pluginOptions' => [
					            'autoclose' => true,
					            'format' => 'dd.mm.yyyy'
					        ]
					    ]); ?>

					    <?= $form->field($model, 'genderId')->dropDownList($genderList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <?= $form->field($model, 'languageId')->dropDownList($languageList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <?= $form->field($model, 'nationalityId')->dropDownList($nationalityList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

					    <!-- Personal user Informations -->
					    <?= $form->field($model, 'preName')->textInput(["class" => 'form-control form-control-color', 'readonly'=> (empty($model->preName)? false : true) ]) ?>
					    <?= $form->field($model, 'lastName')->textInput(["class" => 'form-control form-control-color', 'readonly'=> (empty($model->lastName)? false : true)]) ?>
					    <?= $form->field($model, 'zipCode')->textInput(["class" => 'form-control form-control-color', 'readonly'=> (empty($model->zipCode)? false : true)]) ?>
					    <?= $form->field($model, 'city')->textInput(["class" => 'form-control form-control-color', 'readonly'=> (empty($model->city)? false : true)]) ?>
					    <?= $form->field($model, 'street')->textInput(["class" => 'form-control form-control-color', 'readonly'=> (empty($model->street)? false : true)]) ?>

					    <!-- Social media informations -->
					    <?= $form->field($model, 'twitterAccount')->textInput(["class" => 'form-control form-control-color']) ?>
					    <?= $form->field($model, 'twitterChannels')->textInput(["class" => 'form-control form-control-color']) ?>
					    <?= $form->field($model, 'discordName')->textInput(["class" => 'form-control form-control-color', 'readonly'=> (empty($model->discordName)? false : true)]) ?>
					    <?= $form->field($model, 'discordServer')->textInput(["class" => 'form-control form-control-color']) ?>

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