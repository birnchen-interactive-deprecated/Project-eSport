<?php

/* @var $this yii\web\View *
 * @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var mainTeamPlayerList array
/* @var $model app\modules\teams\models\formModel\SubTeamDetailsForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;



\app\modules\teams\assets\TeamsAsset::register($this);

?>
<div class="site-editSubTeamMemberDetails">
    <?php $form = ActiveForm::begin([
        'id' => 'sub-team-member-details-form',
        'options' => ['class' => 'form-vertical']
    ]); ?>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="panel panel-default panel-color">
                <div class="panel-heading panel-color">
                    <h3 class="panel-title panel-color"><?=\app\modules\teams\Module::t('teams','DetailsMemberHead', $model->siteLanguage->locale)?></h3>
                </div>
                <div class="panel-body panel-color">

                    <div class="col-md-12">
                        <!-- Default informations -->
                        <?= $form->field($model, 'mainPlayer_1')->textInput(["class" => 'form-control form-control-color','readonly'=> true]) ?>
                        <?= $form->field($model, 'mainPlayer_2')->textInput(["class" => 'form-control form-control-color','readonly'=> true]) ?>

                        <?php if($model->maxMainPlayer > 2) : ?>
               				<?php if($model->mainPlayer_3 != null) : ?>
                        		<?= $form->field($model, 'mainPlayer_3')->textInput(["class" => 'form-control form-control-color','readonly'=> true]) ?>
                    		<?php else : ?>
                    			<?= $form->field($model, 'mainPlayer_3')->dropDownList($model->membersList, ["class" => 'form-control form-control-color', 'prompt' => 'Bitte auswählen']) ?>
                        	<?php endif; ?>
                        <?php endif; ?>
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