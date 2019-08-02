<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Neues Passwort vergeben');
?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'form-vertical',
        'enctype' => "multipart/form-data"
    ]
]); ?>

<div class="center-block login-container">
    <div class="panel panel-default panel-color text-color">
        <div class="panel-body panel-color text-color">

            <div class="row">
                <div class="col-lg-10 col-lg-offset-0">
                    Bitte vergeben Sie hier nun Ihr neues Passwort.
                </div>
            </div>
            <br>

            <?= $form->field($model, 'oldPassword')->passwordInput(['class' => 'form-control form-control-color'],['placeholder' => Yii::t('app', 'altes Passwort')]) ?>

            <?= $form->field($model, 'newPassword')->passwordInput(['class' => 'form-control form-control-color'],['placeholder' => Yii::t('app', 'neues Passwort')]) ?>

            <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['class' => 'form-control form-control-color'],['placeholder' => Yii::t('app', 'neues  Passwort wiederholen')]) ?>

            <?= Html::submitButton(Yii::t('app', 'Passwort ändern'), ['class' => 'btn mediumButton btn-large btn-block']) ?>
        </div>
    </div>
</div>/

<?php ActiveForm::end(); ?>