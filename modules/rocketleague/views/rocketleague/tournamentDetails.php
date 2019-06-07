<?php

/* @var $this yii\web\View
 * @var $tournament \app\modules\core\models\Tournament
 * @var $ruleSet array
 * @var $participatingEntrys array
 * @var $brackets array
 * @var $siteLanguage
 */

use app\modules\tournaments\models\TeamParticipating;
use app\modules\tournaments\models\PlayerParticipating;

use app\modules\teams\models\SubTeam;

use app\modules\user\models\User;

use app\modules\tournamenttrees\models\TournamentEncounter;

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

$user = null;
if(Yii::$app->user->identity != null)
{
    $user = Yii::$app->user->identity;
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

$this->title = \app\modules\rocketleague\Module::t('details', 'tournamentdetails', $siteLanguage->locale);
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
                <th><?= \app\modules\rocketleague\Module::t('details', 'paragraph', $siteLanguage->locale) ?></th>
                <th><?= \app\modules\rocketleague\Module::t('details', 'reglement', $siteLanguage->locale) ?></th>
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
            <th class="namedHeader" colspan="2"><?= \app\modules\rocketleague\Module::t('details', 'pointstable', $siteLanguage->locale) ?></th>
        </tr>
        <tr class="bg-warning fold">
            <th width="50%" style="text-align: right"><?= \app\modules\rocketleague\Module::t('details', 'placement', $siteLanguage->locale) ?></th>
            <th width="50%"><?= \app\modules\rocketleague\Module::t('details', 'points', $siteLanguage->locale) ?></th>
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
            <th class="namedHeader" colspan="5"><?= \app\modules\rocketleague\Module::t('details', 'participants', $siteLanguage->locale) ?></span></th>
        </tr>
        <tr class="bg-success">
            <th colspan="2"><?= \app\modules\rocketleague\Module::t('details', $userTeam, $siteLanguage->locale); ?><span class="badge"><?= count($participatingEntrys); ?></th>
            <?php if ('Team' === $userTeam): ?>
                <th><?= \app\modules\rocketleague\Module::t('details', 'User', $siteLanguage->locale) ?></th>
            <?php endif; ?>
            <th><?= \app\modules\rocketleague\Module::t('details', 'checkedinstatus', $siteLanguage->locale) ?><span class="badge"><?= $countCheckedIn . ' / 32'; ?></span></th>
            <th><?= \app\modules\rocketleague\Module::t('details', 'notes', $siteLanguage->locale) ?></th>
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
            $checkInText = (false === $checkInStatus) ? \app\modules\rocketleague\Module::t('details', 'notcheckedin', $siteLanguage->locale) : \app\modules\rocketleague\Module::t('details', 'checkedin', $siteLanguage->locale);
            $checkInClass = (false === $checkInStatus) ? 'alert-danger' : 'alert-success';

            $disqStatus = $entry->getDisqualifiedStatus($tournament->getId());
            $disqText = ($disqStatus) ? 'Disqualifiziert' : '';
            $disqClass = ($disqStatus) ? 'alert-danger' : '';
            ?>
            <tr class="fold">

                <td class="imageCell">
                    <?= Html::img($imgPath . '.webp', ['class' => 'entry-logo', 'alt' => "profilePic", 'aria-label' => 'profilePic', 'onerror' =>'this.src="' . $imgPath . '.png"' ]); ?>
                </td>

                <td class="nameCell">
                    <?= ($entry instanceOf User) ? '' : $entry->getTeamShortCode() . ' | '; ?>
                        <?= Html::a($entryName , (($entry instanceOf User) ? ['/user/details', 'id' => $entry->getId()] : ['/teams/sub-team-details', 'id' => $entry->getId()])); ?>
                    </td>
                <?php if ('Team' == $userTeam): ?>
                    <td><?= $entry->getTeamMembersFormatted(); ?></td>
                <?php endif; ?>
                <td class="checkInCell <?= $checkInClass; ?>"><?= $checkInText ?></td>
                <td class="disqCell <?= $disqClass; ?>"><?= $disqText ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (Yii::$app->user->identity instanceOf User && Yii::$app->user->identity->getId() <= 4): ?>
        <?php $btnText = (count($brackets['winner']) > 0) ? 'Brackets neu erstellen' : 'Brackets erstellen'; ?>
        <?php if ($now->diff($turnierStart)->invert == 0 && $btnText === 'Brackets erstellen'): ?>
            <?= Html::a($btnText, ['/rocketleague/create-brackets', 'tournament_id' => $tournament->getId()], ['class' => 'btn btn-success']); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($now->diff($turnierStart)->invert == 1 || (Yii::$app->user != null && Yii::$app->user->identity instanceOf User && Yii::$app->user->identity->getId() <= 4)): ?>

        <?php   
            $isAdmin = false;
            if (Yii::$app->user != null && Yii::$app->user->identity instanceOf User && Yii::$app->user->identity->getId() <= 4) {
                $isAdmin = true;
            }
        ?>

        <div class="scrollableBracket">
            
            <h1>Winner Bracket</h1>
            <div class="winnerBracket">
                
                <?php $round = 0; ?>
                <?php foreach ($brackets['winner'] as $round => $roundBrackets): ?>
                    <?php $firstBracket = reset($roundBrackets); ?>

                    <div class="bracketRound">

                        <div class="roundTitle">Round <?= $round; ?></div>
                        <div class="roundTitle">Best of <?= $firstBracket->getBestOf(); ?></div>

                        <?php foreach ($roundBrackets as $bracketKey => $bracket): ?>
                            <?php

                                $bracketFinished = $bracket->checkisFinished();
                                $class1 = '';
                                $class2 = '';
                                if ($bracketFinished === 1) {
                                    $class1 = 'winner';
                                    $class2 = 'looser';
                                } else if ($bracketFinished === 2) {
                                    $class1 = 'looser';
                                    $class2 = 'winner';
                                }

                                $liveStream = $bracket->getLiveStreamClass();

                                $bracketEncounter = $bracket->getEncounterId();
                                $bracketParticipants = $bracket->getParticipants();
                                $bracketParticipants[0] = ($bracketParticipants[0] === NULL) ? 'FREILOS' : $bracketParticipants[0];
                                $bracketParticipants[1] = ($bracketParticipants[1] === NULL) ? 'FREILOS' : $bracketParticipants[1];

                                $participant1 = $bracketParticipants[0];
                                $participant2 = $bracketParticipants[1];

                                if (strpos($round, 'Finale') !== false) {
                                    $rundenInfo = 'Finale';
                                } else {
                                    $rundenInfo = 'R' . $round . str_pad($bracketEncounter, 2, '0', STR_PAD_LEFT);
                                }

                                $goals = TournamentEncounter::getGoals($tournament->getId(), $bracket->getId(), $bracket->getBestOf());
                            ?>
                            <?php if ($participant1 != 'FREILOS' && $participant2 != 'FREILOS') : ?>
                                <span class="bracketEncounter">Bracket <?= $bracketEncounter; ?> | Gamename and Password: <?= $rundenInfo; ?></span>
                                <?php if (Yii::$app->user->identity instanceOf User && Yii::$app->user->identity->getId() <= 4): ?>
                                    <div>
                                        <?= Html::a('Live Stream umschalten', ['/rocketleague/bracket-live-stream', 'tournament_id' => $tournament->getId(), 'bracketId' => $bracket->getId()]); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="bracket <?= $liveStream; ?>">
                                    <div class="bracketParticipant <?= $class1; ?>">
                                        <?= $participant1; ?>
                                        <!-- Captains/Deputy Area -->
                                        <?php if ($isAdmin || $bracket->isManageable($user, 1)) : ?>
                                            <div class="takeWinner" style="float: right;">
                                                <?php echo Html::a('',
                                                    [
                                                        "/rocketleague/close-bracket",
                                                        'tournament_id' => $tournament->getId(),
                                                        'bracketId' => $bracket->getId()
                                                    ],
                                                    ['class' => "glyphicon glyphicon-cloud-upload",
                                                        'title' => "Complete Encounter"
                                                    ]
                                                ); ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="takeWinner" style="float: right;">
                                                <?php echo Html::a('',
                                                    [
                                                        "/rocketleague/bracket-details",
                                                        'tournament_id' => $tournament->getId(),
                                                        'bracketId' => $bracket->getId()
                                                    ],
                                                    ['class' => "glyphicon glyphicon-search",
                                                        'title' => "Complete Encounter"
                                                    ]
                                                ); ?>
                                            </div>
                                        <?php endif; ?>
                                        <!-- End of Captains/Deputy Area -->
                                        <!-- Administrative Area -->
                                        <?php if ($isAdmin) : ?>
                                            <div class="takeWinner" style="float: right;">
                                                <?php echo Html::a('',
                                                    [
                                                        "/rocketleague/move-player-in-bracket",
                                                        'tournament_id' => $tournament->getId(),
                                                        'winner' => 1,
                                                        'bracketId' => $bracket->getId()
                                                    ],
                                                    ['class' => "glyphicon glyphicon-circle-arrow-right",
                                                        'title' => "Edit Details"
                                                    ]
                                                ); ?>
                                            </div>
                                        <?php endif ?>
                                        <!-- End of Administrative Area -->
                                        <div class="takeWinner" style="float:right;">
                                            <?php foreach ($goals['left'] as $key => $goal): ?>
                                                <div class="goals" style="float:left;"><?= $goal; ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="bracketParticipant <?= $class2; ?>">
                                        <?= $participant2; ?>
                                        <!-- Captains/Deputy Area -->
                                        <?php if ($isAdmin || $bracket->isManageable($user, 2)) : ?>
                                            <div class="takeWinner" style="float: right;">
                                                    <?php echo Html::a('',
                                                        [
                                                            "/rocketleague/close-bracket",
                                                            'tournament_id' => $tournament->getId(),
                                                            'bracketId' => $bracket->getId()
                                                        ],
                                                        ['class' => "glyphicon glyphicon-cloud-upload",
                                                            'title' => "Complete Encounter"
                                                        ]
                                                    ); ?>
                                                </div>
                                        <?php else : ?>
                                            <div class="takeWinner" style="float: right;">
                                                <?php echo Html::a('',
                                                    [
                                                        "/rocketleague/bracket-details",
                                                        'tournament_id' => $tournament->getId(),
                                                        'bracketId' => $bracket->getId()
                                                    ],
                                                    ['class' => "glyphicon glyphicon-search",
                                                        'title' => "Complete Encounter"
                                                    ]
                                                ); ?>
                                            </div>
                                        <?php endif; ?>
                                        <!-- End of Captains/Deputy Area -->
                                        <!-- Administrative Area -->
                                        <?php if ($isAdmin) : ?>
                                            <div class="takeWinner" style="float: right;">
                                                <?php echo Html::a('',
                                                    [
                                                        "/rocketleague/move-player-in-bracket",
                                                        'tournament_id' => $tournament->getId(),
                                                        "winner" => 2,
                                                        'bracketId' => $bracket->getId()
                                                    ],
                                                    ['class' => "glyphicon glyphicon-circle-arrow-right",
                                                        'title' => "Edit Details"
                                                    ]
                                                ); ?>
                                            </div>
                                        <?php endif ?>
                                        <!-- End of Administrative Area -->
                                        <div class="takeWinner" style="float:right;">
                                            <?php foreach ($goals['right'] as $key => $goal): ?>
                                                <div class="goals" style="float:left;"><?= $goal; ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>

                <?php endforeach; ?>
            </div>

            <!-- Google Ads bereich -->
            <!-- Tournament Bracket -->
            <div align="center">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Project-eSport Header -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-8480651532892152"
                         data-ad-slot="4634006785"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
            </div>
            <!-- Google Ads bereich -->

            <h1>Looser Bracket</h1> 
            <div class="looserBracket">

                <?php $round = 0; ?>
                <?php foreach ($brackets['looser'] as $round => $roundBrackets): ?>
                    <?php $firstBracket = reset($roundBrackets); ?>

                    <div class="bracketRound">

                        <div class="roundTitle">Round <?= $round; ?></div>
                        <div class="roundTitle">Best of <?= $firstBracket->getBestOf(); ?></div>

                        <?php foreach ($roundBrackets as $bracketKey => $bracket): ?>
                            <?php

                                $bracketFinished = $bracket->checkisFinished();
                                $class1 = '';
                                $class2 = '';
                                if ($bracketFinished === 1) {
                                    $class1 = 'winner';
                                    $class2 = 'looser';
                                } else if ($bracketFinished === 2) {
                                    $class1 = 'looser';
                                    $class2 = 'winner';
                                }

                                $liveStream = $bracket->getLiveStreamClass();

                                $bracketEncounter = $bracket->getEncounterId();
                                $bracketParticipants = $bracket->getParticipants();
                                $bracketParticipants[0] = ($bracketParticipants[0] === NULL) ? 'FREILOS' : $bracketParticipants[0];
                                $bracketParticipants[1] = ($bracketParticipants[1] === NULL) ? 'FREILOS' : $bracketParticipants[1];

                                $participant1 = $bracketParticipants[0];
                                $participant2 = $bracketParticipants[1];

                                $goals = TournamentEncounter::getGoals($tournament->getId(), $bracket->getId(), $bracket->getBestOf());
                            ?>

                            <span class="bracketEncounter">Bracket <?= $bracketEncounter; ?> | Gamename and Password: R<?= $round . str_pad($bracketEncounter, 2, '0', STR_PAD_LEFT); ?></span>
                            <?php if (Yii::$app->user->identity instanceOf User && Yii::$app->user->identity->getId() <= 4): ?>
                                <div><?= Html::a('Live Stream umschalten', ['/rocketleague/bracket-live-stream', 'tournament_id' => $tournament->getId(), 'bracketId' => $bracket->getId()]); ?></div>
                            <?php endif; ?>
                            <div class="bracket <?= $liveStream; ?>">
                                <div class="bracketParticipant <?= $class1; ?>">
                                    <?= $participant1; ?>
                                    <!-- Captains/Deputy Area -->
                                    <?php if ($isAdmin || $bracket->isManageable($user, 1)) : ?>
                                        <div class="takeWinner" style="float: right;">
                                            <?php echo Html::a('',
                                                [
                                                    "/rocketleague/close-bracket",
                                                    'tournament_id' => $tournament->getId(),
                                                    'bracketId' => $bracket->getId()
                                                ],
                                                ['class' => "glyphicon glyphicon-cloud-upload",
                                                    'title' => "Complete Encounter"
                                                ]
                                            ); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="takeWinner" style="float: right;">
                                            <?php echo Html::a('',
                                                [
                                                    "/rocketleague/bracket-details",
                                                    'tournament_id' => $tournament->getId(),
                                                    'bracketId' => $bracket->getId()
                                                ],
                                                ['class' => "glyphicon glyphicon-search",
                                                    'title' => "Complete Encounter"
                                                ]
                                            ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- End of Captains/Deputy Area -->
                                    <?php if ($isAdmin) : ?>
                                        <div class="takeWinner" style="float: right;">
                                            <?php echo Html::a('',
                                                [
                                                    "/rocketleague/move-player-in-bracket",
                                                    'tournament_id' => $tournament->getId(),
                                                    "winner" => 1,
                                                    'bracketId' => $bracket->getId()
                                                ],
                                                ['class' => "glyphicon glyphicon-circle-arrow-right",
                                                    'title' => "Edit Details"
                                                ]
                                            ); ?>
                                        </div>
                                    <?php endif ?>
                                    <div class="takeWinner" style="float:right;">
                                        <?php foreach ($goals['left'] as $key => $goal): ?>
                                            <div class="goals" style="float:left;"><?= $goal; ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="bracketParticipant <?= $class2; ?>">
                                    <?= $participant2; ?>
                                    <!-- Captains/Deputy Area -->
                                    <?php if ($isAdmin || $bracket->isManageable($user, 2)) : ?>
                                        <div class="takeWinner" style="float: right;">
                                            <?php echo Html::a('',
                                                [
                                                    "/rocketleague/close-bracket",
                                                    'tournament_id' => $tournament->getId(),
                                                    'bracketId' => $bracket->getId()
                                                ],
                                                ['class' => "glyphicon glyphicon-cloud-upload",
                                                    'title' => "Complete Encounter"
                                                ]
                                            ); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="takeWinner" style="float: right;">
                                            <?php echo Html::a('',
                                                [
                                                    "/rocketleague/bracket-details",
                                                    'tournament_id' => $tournament->getId(),
                                                    'bracketId' => $bracket->getId()
                                                ],
                                                ['class' => "glyphicon glyphicon-search",
                                                    'title' => "Complete Encounter"
                                                ]
                                            ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- End of Captains/Deputy Area -->
                                    <?php if ($isAdmin) : ?>
                                        <div class="takeWinner" style="float: right;">
                                            <?php echo Html::a('',
                                                [
                                                    "/rocketleague/move-player-in-bracket",
                                                    'tournament_id' => $tournament->getId(),
                                                    "winner" => 2,
                                                    'bracketId' => $bracket->getId()
                                                ],
                                                ['class' => "glyphicon glyphicon-circle-arrow-right",
                                                    'title' => "Edit Details"
                                                ]
                                            ); ?>
                                        </div>
                                    <?php endif ?>
                                    <div class="takeWinner" style="float:right;">
                                        <?php foreach ($goals['right'] as $key => $goal): ?>
                                            <div class="goals" style="float:left;"><?= $goal; ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endforeach; ?>
            </div>
        </div>

    <?php else: ?>
        <b>!!!</b> Hier erscheint nach Turnierstart der Turnierbaum <b>!!!</b>
    <?php endif; ?>

    <!-- <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdo7W8BCQxO0ZglrrFiAHvSZtsu3GoIyq5mNa3Eeuuwdbfdpg/viewform?embedded=true" width="1055" height="1010" frameborder="0" marginheight="0" marginwidth="0">Wird geladen...</iframe>
    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLScNl-8L9WKZwcHmawQLwnIzj_GfqbyAVlHw4BCZ6dlE-M9Fcw/viewform?embedded=true" width="1055" height="1340" frameborder="0" marginheight="0" marginwidth="0">Wird geladen...</iframe> -->

</div>