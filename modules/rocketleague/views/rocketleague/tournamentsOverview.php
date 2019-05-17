<?php

/* @var $this yii\web\View
 * @var $tournamentList array<Tournaments>
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

usort($tournamentList, function ($a, $b) {
    return $a->getDtStartingTime() > $b->getDtStartingTime();
});

$subTeams = [];
if(Yii::$app->user->identity != null)
{
    $user = Yii::$app->user->identity;
    $subTeams = $user->getOwnedSubTeams()->all();
}


$now = new DateTime();
$tz = new DateTimeZone('Europe/Vienna');
$di = DateInterval::createFromDateString($tz->getOffset($now) . ' seconds');
$now->add($di);

$registerTurnier = array();
$checkInTurnier = array();
$preCheckInTurnier = array();
$preRunningTurnier = array();
$runningTurnier = array();
$archivTurnier = array();
$plannedTurnier = array();
foreach ($tournamentList as $tournament) {

    $turnierStart = new DateTime($tournament->getDtStartingTime());
    $turnierEnd = new DateTime($tournament->getDtStartingTime());
    $turnierEnd->setTime(23, 59, 59);
    $diffStart = $now->diff($turnierStart);
    $diffEnd = $now->diff($turnierEnd);
    if (1 === $diffStart->invert && 1 === $diffEnd->invert) {
        $archivTurnier[] = $tournament;
        continue;
    }

    $checkInBegin = new DateTime($tournament->getDtCheckinBegin());
    $diffBegin = $now->diff($checkInBegin);

    $checkInEnd = new DateTime($tournament->getDtCheckinEnd());
    $diffEnd = $now->diff($checkInEnd);

    $registerStart = new DateTime($tournament->getDtRegisterBegin());
    $diffRegBegin = $now->diff($registerStart);

    $registerEnd = new DateTime($tournament->getDtRegisterEnd());
    $diffRegEnd = $now->diff($registerEnd);

    if (1 === $diffRegBegin->invert && 0 === $diffRegEnd->invert) {
        $registerTurnier[] = $tournament;
        continue;
    }
    if (1 === $diffRegEnd->invert && 0 === $diffBegin->invert) {
        $preCheckInTurnier[] = $tournament;
        continue;
    }
    if (1 === $diffBegin->invert && 0 === $diffEnd->invert) {
        $checkInTurnier[] = $tournament;
        continue;
    }
    if (1 === $diffEnd->invert && 0 === $diffStart->invert) {
        $preRunningTurnier[] = $tournament;
        continue;
    }
    if (1 === $diffStart->invert) {
        $runningTurnier[] = $tournament;
        continue;
    }
    $plannedTurnier[] = $tournament;
}

usort($archivTurnier, function ($a, $b) {
    return $a->getDtStartingTime() < $b->getDtStartingTime();
});

$this->title = 'RL Tournament Overview';
?>
<div class="site-rl-tournament-overview">

    <h1>Rocket League Tournament Overview</h1>

    <?php if (count($runningTurnier) > 0 || count($preRunningTurnier) > 0): ?>
        <table class="turnierStatus table table-bordered table-striped table-hover">
            <thead>
            <tr class="bg-success">
                <th class="namedHeader" colspan="3">Laufende Turniere <span
                            class="badge"><?= (count($runningTurnier) + count($preRunningTurnier)); ?></span></th>
            </tr>
            <tr class="bg-success">
                <th>Turniername</th>
                <th>Startdatum</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($runningTurnier as $tournament): ?>
                <tr>
                    <td><?= Html::a($tournament->showRealTournamentName(), ['/rocketleague/tournament-details', 'id' => $tournament->getId()]) ?>
                        <span class="badge"><?= count($tournament->getParticipants()->all()); ?></span></td>
                    <td><?= $tournament->getDtStartingTime(); ?></td>
                    <td>Running</td>
                </tr>
            <?php endforeach; ?>
            <?php foreach ($preRunningTurnier as $tournament): ?>
                <tr>
                    <td><?= Html::a($tournament->showRealTournamentName(), ['/rocketleague/tournament-details', 'id' => $tournament->getId()]) ?>
                        <span class="badge"><?= count($tournament->getParticipants()->all()); ?></span></td>
                    <td><?= $tournament->getDtStartingTime(); ?></td>
                    <td>Preparing</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (count($checkInTurnier) > 0 || count($preCheckInTurnier) > 0): ?>
        <table class="turnierStatus table table-bordered table-striped table-hover">
            <thead>
            <tr class="bg-success">
                <th class="namedHeader" colspan="4">Check In Turniere <span
                            class="badge"><?= (count($checkInTurnier) + count($preCheckInTurnier)); ?></span></th>
            </tr>
            <tr class="bg-success">
                <th>Turniername</th>
                <th>Checkin Datum</th>
                <th>Checkin Zeitraum</th>
                <th>Checkin</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($checkInTurnier as $tournament): ?>
                <?php
                $checkInBegin = new DateTime($tournament->getDtCheckinBegin());
                $checkInEnd = new DateTime($tournament->getDtCheckinEnd());
                ?>
                <tr>
                    <td><?= Html::a($tournament->showRealTournamentName(), ['/rocketleague/tournament-details', 'id' => $tournament->getId()]) ?>
                        <span class="badge"><?= count($tournament->getParticipants()->all()); ?></span></td>
                    <td><?= $checkInBegin->format('Y-m-d'); ?></td>
                    <td><?= $checkInBegin->format('H:i'); ?> - <?= $checkInEnd->format('H:i'); ?></td>
                    <td>
                        <?php
                        if ($tournament->showCheckInBtn($subTeams, $user)) {
                            $btns = $tournament->getCheckInBtns($subTeams, $user);
                            foreach ($btns as $btn) {

                                $form = ActiveForm::begin([
                                    'id' => 'registerForm',
                                ]);
                                echo Html::hiddenInput($btn['type'], $btn['id']);
                                echo Html::hiddenInput('tournamentId', $tournament->getId());
                                echo $btn['btn'];
                                echo ' ';
                                echo $btn['name'];
                                ActiveForm::end();
                            }
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php foreach ($preCheckInTurnier as $tournament): ?>
                <?php
                $checkInBegin = new DateTime($tournament->getDtCheckinBegin());
                $checkInEnd = new DateTime($tournament->getDtCheckinEnd());
                ?>
                <tr>
                    <td><?= Html::a($tournament->showRealTournamentName(), ['/rocketleague/tournament-details', 'id' => $tournament->getId()]); ?> <span
                                class="badge"><?= count($tournament->getParticipants()->all()); ?></span></td>
                    <td><?= $checkInBegin->format('Y-m-d'); ?></td>
                    <td><?= $checkInBegin->format('H:i'); ?> - <?= $checkInEnd->format('H:i'); ?></td>
                    <td>Preparing</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (count($registerTurnier) > 0): ?>
        <table class="turnierStatus table table-bordered table-striped table-hover">
            <thead>
            <tr class="bg-info">
                <th class="namedHeader" colspan="4">Registration Turniere <span
                            class="badge"><?= count($registerTurnier); ?></span></th>
            </tr>
            <tr class="bg-info">
                <th>Turniername</th>
                <th>Startdatum</th>
                <th>Checkin Zeitraum</th>
                <th>Register</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($registerTurnier as $tournament): ?>
                <?php
                $checkInBegin = new DateTime($tournament->getDtCheckinBegin());
                $checkInEnd = new DateTime($tournament->getDtCheckinEnd());
                ?>
                <tr>
                    <td><?= Html::a($tournament->showRealTournamentName(), ['/rocketleague/tournament-details', 'id' => $tournament->getId()]) ?>
                        <span class="badge"><?= count($tournament->getParticipants()->all()); ?></span></td>
                    <td><?= //TODO:: Yii::$app->formatter->asDatetime($tournament->getDtStartingTime()) überall
                         $tournament->getDtStartingTime(); ?></td>
                    <td><?= $checkInBegin->format('H:i'); ?> - <?= $checkInEnd->format('H:i'); ?></td>
                    <td>
                        <?php
                        if ($tournament->showRegisterBtn($subTeams, $user)) {
                            $btns = $tournament->getRegisterBtns($subTeams, $user);
                            foreach ($btns as $btn) {

                                $form = ActiveForm::begin([
                                    'id' => 'registerForm',
                                ]);
                                echo Html::hiddenInput($btn['type'], $btn['id']);
                                echo Html::hiddenInput('tournamentId', $tournament->getId());
                                echo $btn['btn'];
                                echo ' ';
                                echo $btn['name'];
                                ActiveForm::end();
                            }
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (count($plannedTurnier) > 0): ?>
        <table class="turnierStatus foldable table table-bordered table-striped table-hover">
            <thead>
            <tr class="bg-warning">
                <th class="namedHeader" colspan="2">Geplante Turniere <span
                            class="badge"><?= count($plannedTurnier); ?></span></th>
            </tr>
            <tr class="bg-warning fold">
                <th>Turniername</th>
                <th>Startdatum</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($plannedTurnier as $tournament): ?>
                <tr class="fold">
                    <td><?= Html::a($tournament->showRealTournamentName(), ['/rocketleague/tournament-details', 'id' => $tournament->getId()]) ?></td>
                    <td><?= $tournament->getDtStartingTime(); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (count($archivTurnier) > 0): ?>
        <table class="turnierStatus foldable table table-bordered table-striped table-hover">
            <thead>
            <tr class="bg-warning">
                <th class="namedHeader" colspan="2">Turnier Archive <span
                            class="badge"><?= count($archivTurnier); ?></span></th>
            </tr>
            <tr class="bg-warning fold">
                <th>Turniername</th>
                <th>Startdatum</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($archivTurnier as $tournament): ?>
                <tr class="fold">
                    <td><?= Html::a($tournament->showRealTournamentName(), ['/rocketleague/tournament-details', 'id' => $tournament->getId()]) ?></td>
                    <td><?= $tournament->getDtStartingTime(); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>