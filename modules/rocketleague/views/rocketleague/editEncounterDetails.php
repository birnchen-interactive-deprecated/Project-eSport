<?php

/* @var $this yii\web\View *
 * @var $form yii\bootstrap\ActiveForm
 * @var $id int
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>
<div class="site-editEncounterDetails">
	<?php $form = ActiveForm::begin([
        'id' => 'tencounter-details-form',
        'options' => ['class' => 'form-vertical']
    ]); ?>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="panel panel-default panel-color">
                <div class="panel-heading panel-color">
                    <h3 class="panel-title panel-color">Encounter Details</h3>
                </div>
                <div class="panel-body panel-color">

                    <div class="col-md-12">

                        <!-- Default informations -->
                        

                        <!-- Management Informations -->
                        
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