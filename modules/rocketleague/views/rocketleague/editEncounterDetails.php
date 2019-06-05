<?php

/* @var $this yii\web\View *
 * @var $form yii\bootstrap\ActiveForm
 * @var $id int
 * @var $player_left User | SubTeam
 * @var $player_right User | SubTeam
 * @var players_left array[User]
 * @var players_right array[User]
 * @var best_of int
 * @var round int
 * @var bracketID int
 * @var tournament_id int
 * @var bracket_id int
 * @var encounterData array
 * @var encounterScreen array
 * @var editable bool
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
        'options' => ['class' => 'form-vertical', 'enctype' => 'multipart/form-data']
    ]); ?>

    <input type="hidden" name="tournament_id" value="<?= $tournament_id; ?>">
    <input type="hidden" name="bracket_id" value="<?= $bracket_id; ?>">

    <div class="col-lg-12 encounterHeader">
        <h1>Encounter Details</h1>
        <h1>Round <?= $round; ?> / Bracket <?= $bracketID; ?></h1>
        <div class="col-lg-6">
            <div class="playerDetails">
                <div class="playerName"><?= $playerNameL; ?></div>
                <?= Html::img($imgLeft  . '.webp', ['class' => 'entry-logo', 'alt' => "profilePic", 'aria-label' => 'profilePic', 'onerror' =>'this.src="' . $imgPath . '.png"' ]); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="playerDetails">
                <div class="playerName"><?= $playerNameR; ?></div>
                <?= Html::img($imgRight . '.webp', ['class' => 'entry-logo', 'alt' => "profilePic", 'aria-label' => 'profilePic', 'onerror' =>'this.src="' . $imgPath . '.png"' ]); ?>
            </div>
        </div>
        <div class="encounterVs">VS.</div>
    </div>

    <div class="col-lg-12 encounterBody">
        <?php for ($b=1; $b <= $best_of; $b++): ?>

        <h2 class="col-lg-12 encounterGameHeader">Game <?= $b; ?></h2>
        <?php if (array_key_exists($b, $encounterScreen)): ?>
            <img class="encounterScreen" src="data:image/webp;base64,<?= $encounterScreen[$b]; ?>" alt="Screenshot Game <?= $b; ?>">
        <?php endif; ?>
        <?php if ($editable): ?>
            <div class="encounterScreenshot">Screenshot: <input type="file" name="screen_<?= $b; ?>"></div>
        <?php endif; ?>

        <div class="col-lg-6 encounterGameBody">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Points</th>
                        <th>Goals</th>
                        <th>Assists</th>
                        <th>Saves</th>
                        <th>Shots</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($players_left as $key => $player): ?>
                        <?php
                            $playerId = $player->getId();

                            $points = '';
                            $goals = '';
                            $assists = '';
                            $saves = '';
                            $shots = '';
                            if (array_key_exists($b, $encounterData)) {
                                if (array_key_exists($playerId, $encounterData[$b])) {

                                    $points = $encounterData[$b][$playerId]['points'];
                                    $goals = $encounterData[$b][$playerId]['goals'];
                                    $assists = $encounterData[$b][$playerId]['assists'];
                                    $saves = $encounterData[$b][$playerId]['saves'];
                                    $shots = $encounterData[$b][$playerId]['shots'];

                                }
                            }
                        ?>
                        <tr>
                            <td><?= $player->getUsername(); ?></td>
                            <td class="encounterField">
                                <?php if ($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][points]" placeholder="empty" value="<?= $points; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $points; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="encounterField">
                                <?php if ($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][goals]" placeholder="empty" value="<?= $goals; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $goals; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="encounterField">
                                <?php if ($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][assists]" placeholder="empty" value="<?= $assists; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $assists; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="encounterField">
                                <?php if ($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][saves]" placeholder="empty" value="<?= $saves; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $saves; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="encounterField">
                                <?php if ($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][shots]" placeholder="empty" value="<?= $shots; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $shots; ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

        <div class="col-lg-6 encounterGameBody">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Points</th>
                        <th>Goals</th>
                        <th>Assists</th>
                        <th>Saves</th>
                        <th>Shots</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($players_right as $key => $player): ?>
                        <?php
                            $playerId = $player->getId();

                            $points = '';
                            $goals = '';
                            $assists = '';
                            $saves = '';
                            $shots = '';
                            if (array_key_exists($b, $encounterData)) {
                                if (array_key_exists($playerId, $encounterData[$b])) {

                                    $points = $encounterData[$b][$playerId]['points'];
                                    $goals = $encounterData[$b][$playerId]['goals'];
                                    $assists = $encounterData[$b][$playerId]['assists'];
                                    $saves = $encounterData[$b][$playerId]['saves'];
                                    $shots = $encounterData[$b][$playerId]['shots'];

                                }
                            }
                        ?>
                        <tr>
                            <td><?= $player->getUsername(); ?></td>
                            <td class="encounterField">
                                <?php if($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][points]" placeholder="empty" value="<?= $points; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $points; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="encounterField">
                                <?php if($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][goals]" placeholder="empty" value="<?= $goals; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $goals; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="encounterField">
                                <?php if($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][assists]" placeholder="empty" value="<?= $assists; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $assists; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="encounterField">
                                <?php if($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][saves]" placeholder="empty" value="<?= $saves; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $saves; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="encounterField">
                                <?php if($editable): ?>
                                    <input class="encounterInput" type="text" name="points[<?= $b; ?>][<?= $playerId; ?>][shots]" placeholder="empty" value="<?= $shots; ?>">
                                <?php else: ?>
                                    <span class="encounterInput"><?= $shots; ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

        <?php endfor; ?>

    </div>

    <div class="col-lg-12 encounterFooter">
        <?= Html::a('Back to Tournament', ['/rocketleague/tournament-details', 'id' => $tournament_id], ['class' => 'btn btn-warning']); ?>
        <?= Html::submitButton("Submit", ['class' => 'btn']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
