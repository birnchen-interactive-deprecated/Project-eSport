<?php

/* @var $this yii\web\View *
 * @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var $player_left User | SubTeam
 * @var $player_right User | SubTeam
 * @var best_of int
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use app\modules\user\models\User;
use app\modules\teams\models\SubTeam;

app\modules\rocketleague\assets\rocketleagueAsset::register($this);

$imgLeft  = ($player_left  instanceof User) ? '/images/userAvatar/' . $player_left->id  : '/images/teams/subTeams/' . $player_left->id;
$imgRight = ($player_right instanceof User) ? '/images/userAvatar/' . $player_right->id : '/images/teams/subTeams/' . $player_right->id;

if (!is_file($_SERVER['DOCUMENT_ROOT'] . '/' . $imgLeft . '.webp')) {
    if (!is_file($_SERVER['DOCUMENT_ROOT'] . '/' . $imgLeft . '.png')) {
        $imgLeft = Yii::getAlias("@web") . '/images/userAvatar/default';
    }
}

if (!is_file($_SERVER['DOCUMENT_ROOT'] . '/' . $imgRight . '.webp')) {
    if (!is_file($_SERVER['DOCUMENT_ROOT'] . '/' . $imgRight . '.png')) {
        $imgRight = Yii::getAlias("@web") . '/images/userAvatar/default';
    }
}

$playerNameL = ($player_left  instanceof User) ? $player_left->getUsername() : $player_left->getName();
$playerNameR = ($player_right  instanceof User) ? $player_right->getUsername() : $player_right->getName();


?>
<div class="site-editEncounterDetails">
	<?php $form = ActiveForm::begin([
        'id' => 'encounter-details-form',
        'options' => ['class' => 'form-vertical']
    ]); ?>

    <div class="col-lg-12">
        <h1>Encounter Details</h1>
        <div class="col-lg-6">
            <div class="playerDetails">
                <div class="playerName"><?= $playerNameL; ?></div>
                <?= Html::img($imgLeft  . '.webp', ['class' => 'entry-logo', 'alt' => "profilePic", 'aria-label' => 'profilePic', 'onerror' =>'this.src="' . $imgPath . '.png"' ]); ?>
                <table>
                    <thead>
                        <tr>
                            <th>Round</th>
                            <th>Points</th>
                            <th>Goals</th>
                            <th>Assists</th>
                            <th>Safes</th>
                            <th>Shots</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($b=1; $b <= $best_of; $b++): ?>
                            <tr>
                                <td><?= $b; ?></td>
                                <td><input type="text" name="p1_points"></td>
                                <td><input type="text" name="p1_goals"></td>
                                <td><input type="text" name="p1_assists"></td>
                                <td><input type="text" name="p1_safes"></td>
                                <td><input type="text" name="p1_shots"></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="playerDetails">
                <div class="playerName"><?= $playerNameR; ?></div>
                <?= Html::img($imgRight . '.webp', ['class' => 'entry-logo', 'alt' => "profilePic", 'aria-label' => 'profilePic', 'onerror' =>'this.src="' . $imgPath . '.png"' ]); ?>
                <table>
                    <thead>
                        <tr>
                            <th>Round</th>
                            <th>Points</th>
                            <th>Goals</th>
                            <th>Assists</th>
                            <th>Safes</th>
                            <th>Shots</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($b=1; $b <= $best_of; $b++): ?>
                            <tr>
                                <td><?= $b; ?></td>
                                <td><input type="text" name="p2_points"></td>
                                <td><input type="text" name="p2_goals"></td>
                                <td><input type="text" name="p2_assists"></td>
                                <td><input type="text" name="p2_safes"></td>
                                <td><input type="text" name="p2_shots"></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <?= Html::submitButton("Speichern", ['class' => 'btn']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
