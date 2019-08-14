<?php
/**
 * Created by PhpStorm.
 * User: Pascal Müller
 * Date: 14.01.2019
 * Time: 11:02
 */

/**
 * @var \app\models\PasswordResetForm $model
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t('app', 'reset password');
?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
    ],
]); ?>

<div class="center-block login-container">
    <div class="panel panel-default panel-color">
        <div class="panel-body panel-color">

            <div class="row">
                <div class="col-lg-10 col-lg-offset-0">
                    Bitte geben Sie hier Ihren Benutzernamen und Email ein.
                </div>
            </div>
            <br>

            <?= $form->field($model, 'username')->textInput(['class' => 'form-control form-control-color'],['placeholder' => Yii::t('app', 'username')]) ?>

            <?= $form->field($model, 'email')->textInput(['class' => 'form-control form-control-color'],['placeholder' => Yii::t('app', 'email')]) ?>

            <?= Html::submitButton(Yii::t('app', 'reset password'), ['class' => 'btn mediumButton btn-large btn-block']) ?>
            <?= Html::a(Yii::t('app', 'back'), Yii::$app->getHomeUrl(), ['class' => 'btn mediumButton  btn-large btn-block']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

