<?php

/* @var $this yii\web\View
 * @var $tournament \app\modules\core\models\Tournament
 * @var $ruleSet array
 * @var $participatingEntrys array
 */

use app\modules\tournaments\models\TeamParticipating;
use app\modules\tournaments\models\PlayerParticipating;

use app\modules\teams\models\SubTeam;

use app\modules\user\models\User;

use yii\helpers\Html;

app\modules\rocketleague\assets\rocketleagueAsset::register($this);

$userTeam = '';
if (isset($participatingEntrys[0])) {
    if ($participatingEntrys[0] instanceOf User) {
        $userTeam = 'User';
    } else {
        $userTeam = 'Team';
    }
}

$countCheckedIn = 0;
foreach ($participatingEntrys as $key => $entry) {

    if ($entry instanceOf User) {
        // $checkedIn = $entry->hasOne(PlayerParticipating::className(), ['user_id' => 'user_id'])->one()->getCheckedIn();
        $tournamentPlayerParticipating = $entry->getPlayerParticipating()->where(['tournament_id' => $tournament->getId()])->one();
        if ($tournamentPlayerParticipating instanceOf PlayerParticipating) {
            $checkedIn = $tournamentPlayerParticipating->getIsCheckedin();
        }
    } else if ($entry instanceOf SubTeam) {
        // $checkedIn = $entry->hasOne(TeamParticipating::className(), ['sub_team_id' => 'sub_team_id'])->one()->getCheckedIn();
        $tournamentTeamParticipating = $entry->getTeamParticipating()->where(['tournament_id' => $tournament->getId()])->one();
        if ($tournamentTeamParticipating instanceOf TeamParticipating) {
            $checkedIn = $tournamentTeamParticipating->getIsCheckedin();
        }
    }
    if (1 == $checkedIn) {
        $countCheckedIn++;
    }
}

$checkInEnd = new DateTime($tournament->getDtCheckinOpen());
$now = new DateTime();
$tz = new DateTimeZone('Europe/Vienna');
$di = DateInterval::createFromDateString($tz->getOffset($now) . ' seconds');
$now->add($di);

if ($now->diff($checkInEnd)->invert == 1) {
    usort($participatingEntrys, function ($a, $b) use ($tournament) {
        return $a->getCheckInStatus($tournament->getId()) < $b->getCheckInStatus($tournament->getId());
    });
}

$turnierStart = new DateTime($tournament->getDtStartingTime());

$challengeId = 'gerta' . $tournament->getModeId() . '_' . $turnierStart->format('ymd');

$this->title = 'Turnier Details';
?>
<div class="site-rl-tournament-details">

    <h1><?= $tournament->showRealTournamentName(); ?></h1>

    <?php if (count($ruleSet['subRulesSet']) > 0): ?>
        <table class="rulesStatus foldable table table-bordered table-striped table-hover">
            <thead>
            <tr class="bg-warning">
                <th class="namedHeader" colspan="2"><?= $ruleSet['baseSet']; ?></th>
            </tr>
            <tr class="bg-warning fold">
                <th>Paragraph</th>
                <th>Reglement</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /** @var  $subRuleSet \app\modules\core\models\TournamentSubrules */
            foreach ($ruleSet['subRulesSet'] as $key => $subRuleSet): ?>
                <tr class="fold">
                    <td><?= $subRuleSet->getParagraph() . ". " . $subRuleSet->getName(); ?></td>
                    <td><?= $subRuleSet->getDescription(); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <table class="points foldable table table-bordered table-striped table-hover">
        <thead>
        <tr class="bg-warning">
            <th class="namedHeader" colspan="2">Punktetabelle</th>
        </tr>
        <tr class="bg-warning fold">
            <th width="50%" style="text-align: right">Platzierung</th>
            <th width="50%">Punkte</th>
        </tr>
        </thead>
        <tbody>
        <tr class="fold">
            <td align="right">1</td>
            <td>20</td>
        </tr>
        <tr class="fold">
            <td align="right">2</td>
            <td>17</td>
        </tr>
        <tr class="fold">
            <td align="right">3</td>
            <td>15</td>
        </tr>
        <tr class="fold">
            <td align="right">4</td>
            <td>13</td>
        </tr>
        <tr class="fold">
            <td align="right">5 - 6</td>
            <td>11</td>
        </tr>
        <tr class="fold">
            <td align="right">7 - 8</td>
            <td>9</td>
        </tr>
        <tr class="fold">
            <td align="right">9 - 12</td>
            <td>7</td>
        </tr>
        <tr class="fold">
            <td align="right">13 - 16</td>
            <td>5</td>
        </tr>
        <tr class="fold">
            <td align="right">17 - 24</td>
            <td>3</td>
        </tr>
        <tr class="fold">
            <td align="right">25 - 32</td>
            <td>1</td>
        </tr>
        <tr class="fold">
            <td align="right">33+</td>
            <td>0</td>
        </tr>

        </tbody>
    </table>

    <table class="participants foldable table table-bordered table-striped table-hover">
        <thead>
        <tr class="bg-success">
            <th class="namedHeader" colspan="5">Registrierungen</span></th>
        </tr>
        <tr class="bg-success">
            <th colspan="2"><?= $userTeam; ?> <span class="badge"><?= count($participatingEntrys); ?></th>
            <?php if ('Team' === $userTeam): ?>
                <th>Spieler</th>
            <?php endif; ?>
            <th>Checked-In <span class="badge"><?= $countCheckedIn . ' / 32'; ?></span></th>
            <th>Disqualifiziert</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($participatingEntrys as $key => $entry): ?>
            <?php

            $imgPath = ($entry instanceOf User) ? '/images/userAvatar/' . $entry->id : '/images/teams/subTeams/' . $entry->id;

            if (!is_file($_SERVER['DOCUMENT_ROOT'] . '/' . $imgPath . '.webp')) {
                if (!is_file($_SERVER['DOCUMENT_ROOT'] . '/' . $imgPath . '.png')) {
                    $imgPath = Yii::getAlias("@web") . '/images/userAvatar/default';
                }
            }

            $entryName = ($entry instanceOf User) ? $entry->getUsername() : $entry->getName();

            $checkInStatus = $entry->getCheckInStatus($tournament->getId());
            $checkInText = (false === $checkInStatus) ? 'Not Checked In' : 'Checked In';
            $checkInClass = (false === $checkInStatus) ? 'alert-danger' : 'alert-success';

            //$disqStatus = $entry->getDisqualifiedStatus($tournament->getId());
            //$disqText = (false === $disqStatus) ? '' : 'Disqualifiziert';
            //$disqClass = (false === $disqStatus) ? '' : 'alert-danger';
            ?>
            <tr class="fold">

                <td class="imageCell">
                    <?= Html::img($imgPath . '.webp', ['class' => 'entry-logo', 'alt' => "profilePic", 'aria-label' => 'profilePic', 'onerror' =>'this.src="' . $imgPath . '.png"' ]); ?>
                </td>

                <td class="nameCell"><?= $entryName; ?></td>
                <?php if ('Team' === $userTeam): ?>
                    <td><?= $entry->getTeamMembersFormatted(); ?></td>
                <?php endif; ?>
                <td class="checkInCell <?= $checkInClass; ?>"><?= $checkInText ?></td>
                <td class="disqCell <?= $disqClass; ?>"><?= $disqText ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($now->diff($turnierStart)->invert == 1): ?>
        <iframe src="https://challonge.com/de/<?= $challengeId; ?>/module" width="100%" height="500" frameborder="0"
                scrolling="auto" allowtransparency="true"></iframe>
    <?php else: ?>
        <b>!!!</b> Hier erscheint nach Turnierstart der Turnierbaum <b>!!!</b>
    <?php endif; ?>

    <?php if (Yii::$app->user->identity instanceOf User && Yii::$app->user->identity->getId() === 4): ?>
        <?php Html::a('Brackets erstellen', ['/rocketleague/create-brackets', 'tournament_id' => $tournament->getId()]); ?>
    <?php endif; ?>
</div>