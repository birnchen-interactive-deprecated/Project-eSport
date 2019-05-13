<?php

/* @var $this yii\web\View *
<<<<<<< HEAD
/* @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var $gamesList array
 * @var $platformList array
/* @var $model app\modules\platformgames\models\formModel\UserGameForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
=======
 * /* @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var $gamesList array
 * @var $platformList array
 * /* @var $model app\modules\platformgames\models\formModel\UserGameForm
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
>>>>>>> 4c8595c4549f77ac54ee020e4e3d51f197d37e5b

\app\modules\user\assets\UserAsset::register($this);

?>

<div class="site-addGame">
<<<<<<< HEAD
=======


    <?php $form = ActiveForm::begin([
        'id' => 'user-games-form',
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
                        <?= $form->field($model, 'player_id')->textInput(["class" => 'form-control form-control-color']) ?>

                        <?= $form->field($model, 'game_id')->dropDownList($gamesList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <?= $form->field($model, 'platform_id')->dropDownList($platformList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>

                        <?= $form->field($model, 'visible')->checkbox() ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="col-md-12">
        <?= Html::submitButton("Speichern", ['class' => 'btn mediumButton pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>


>>>>>>> 4c8595c4549f77ac54ee020e4e3d51f197d37e5b
</div>