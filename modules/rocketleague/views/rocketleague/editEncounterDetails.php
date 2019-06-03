<?php

/* @var $this yii\web\View *
 * @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var $player_left User | SubTeam
 * @var $player_right User | SubTeam
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$imgLeft  = ($player_left  instanceof User) ? '/images/userAvatar/' . $player_left->id  : '/images/teams/subTeams/' . $player_left->id;
$imgRight = ($player_right instanceof User) ? '/images/userAvatar/' . $player_right->id : '/images/teams/subTeams/' . $player_right->id;

?>
<div class="site-editEncounterDetails">
	<?php $form = ActiveForm::begin([
        'id' => 'encounter-details-form',
        'options' => ['class' => 'form-vertical']
    ]); ?>

    <div class="col-lg-12">
        <h1>Encounter Details</h1>
        <div class="col-lg-6">
            <?= Html::img($imgLeft  . '.webp', ['class' => 'entry-logo', 'alt' => "profilePic", 'aria-label' => 'profilePic', 'onerror' =>'this.src="' . $imgPath . '.png"' ]); ?>
        </div>
        <div class="col-lg-6">
            <?= Html::img($imgRight . '.webp', ['class' => 'entry-logo', 'alt' => "profilePic", 'aria-label' => 'profilePic', 'onerror' =>'this.src="' . $imgPath . '.png"' ]); ?>
        </div>
    </div>

    <div class="col-lg-12">
        <?= Html::submitButton("Speichern", ['class' => 'btn mediumButton pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>