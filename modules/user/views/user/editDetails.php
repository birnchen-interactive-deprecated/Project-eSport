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
                    <h3 class="panel-title panel-color">Anlegen</h3>
                </div>
                <div class="panel-body panel-color">

                    <div class="col-md-12">
                        <?= $form->field($model, 'username')->textInput(["class" => 'form-control form-control-color']) ?>

                        <?= $form->field($model, 'genderId')->dropDownList($genderList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <?= $form->field($model, 'languageId')->dropDownList($languageList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <?= $form->field($model, 'nationalityId')->dropDownList($nationalityList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>
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