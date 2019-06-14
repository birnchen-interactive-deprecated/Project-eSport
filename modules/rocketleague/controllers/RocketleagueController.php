<?php
/**
 * Created by PhpStorm.
 * User: Pierre Köhler
 * Date: 03.04.2019
 * Time: 16:11
 */

namespace app\modules\rocketleague\controllers;

use Yii;

use app\widgets\Alert;

use app\components\BaseController;


use app\modules\teams\models\SubTeam;
use app\modules\tournaments\models\Tournament;
use app\modules\tournaments\models\PlayerParticipating;
use app\modules\tournaments\models\TeamParticipating;

use app\modules\tournamenttrees\models\Bracket;
use app\modules\tournamenttrees\models\TournamentEncounter;
use app\modules\tournamenttrees\models\TournamentEncounterConfirm;
use app\modules\tournamenttrees\models\TournamentEncounterScreens;

use app\modules\tournamenttrees\models\formModels\EncounterDetailsForm;

use app\modules\user\models\User;
use app\modules\user\models\Language;

class RocketleagueController extends BaseController
{
	/**
     * Rocket League News Page
     *
     * @return string
     */
    public function actionNews()
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/../modules/rss_feeds/rocketLeague/rl_feed.xml');

        $data = [
            [
                'title' => '',
                'html' => '',
            ],
            [
                'title' => '',
                'html' => '',
            ],
            [
                'title' => '',
                'html' => '',
            ],
        ];

        $xmlError = libxml_get_errors();
        if (empty($xmlError)) {

            $key = 0;
            foreach ($xml->channel->item as $item) {

                if (3 === $key) {
                    break;
                }

                $data[$key++] = [
                    'title' => $item->title->__toString(),
                    'html' => $item->description->__toString(),
                ];

            }
        }

        return $this->render('news',
            [
                'data' => $data,
            ]);
    }

    /**
     * @param $pos
     * @return string
     */
    public function actionNewsDetails($pos)
    {
        $siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/../modules/rss_feeds/rocketLeague/rl_feed.xml');

        $data = [
            [
                'title' => '',
                'html' => '',
            ],
            [
                'title' => '',
                'html' => '',
            ],
            [
                'title' => '',
                'html' => '',
            ],
        ];

        $xmlError = libxml_get_errors();
        if (empty($xmlError)) {

            $key = 0;
            foreach ($xml->channel->item as $item) {

                if (3 === $key) {
                    break;
                }

                $data[$key++] = [
                    'title' => $item->title->__toString(),
                    'html' => $item->description->__toString(),
                ];

            }
        }
        
        return $this->render('newsDetails',
            [
                'data' => $data,
                'pos' => $pos,
                '$siteLanguage' => $siteLanguage,
            ]);
    }

    /**
     * Rocket League Team list
     *
     * @return string
     */
    public function actionTeamsOverview()
    {
        $teamHierarchy = SubTeam::getTeamHierarchyByGame(1);
        $siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');

        return $this->render('teamsOverview',
            [
                'teamHierarchy' => $teamHierarchy,
                'siteLanguage' => $siteLanguage,
            ]
        );
    }

    /**
     * Rocket League Tournament
     */
    public function actionTournaments()
    {
        $siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');

        if (is_array($_POST) && isset($_POST['tournamentId'])) {

            if (isset($_POST['user'])) {

                $turnierId = (int)$_POST['tournamentId'];
                $userId = (int)$_POST['user'];

                if ($_POST['submitText'] === 'Registrieren') {

                    $newPlayer = new PlayerParticipating();
                    $newPlayer->tournament_id = $turnierId;
                    $newPlayer->user_id = $userId;
                    $newPlayer->insert();

                } else if ($_POST['submitText'] === 'Abmelden') {
                    $playerParticipating = PlayerParticipating::findPlayerParticipating($turnierId, $userId);
                    if (NULL !== $playerParticipating) {
                        $playerParticipating->delete();
                    }
                } else if ($_POST['submitText'] === 'Check-In') {
                    $playerParticipating = PlayerParticipating::findPlayerParticipating($turnierId, $userId);
                    if (NULL !== $playerParticipating) {
                        $playerParticipating->checked_in = true;
                        $playerParticipating->update();
                    }
                } else if ($_POST['submitText'] === 'Check-Out') {
                    $playerParticipating = PlayerParticipating::findPlayerParticipating($turnierId, $userId);
                    if (NULL !== $playerParticipating) {
                        $playerParticipating->checked_in = null;
                        $playerParticipating->update();
                    }
                }

            } else if (isset($_POST['subTeam'])) {

                $turnierId = (int)$_POST['tournamentId'];
                $subTeamId = (int)$_POST['subTeam'];

                if ($_POST['submitText'] === 'Registrieren') {

                    $newSubTeam = new TeamParticipating();
                    $newSubTeam->tournament_id = $turnierId;
                    $newSubTeam->sub_team_id = $subTeamId;
                    $newSubTeam->insert();

                } else if ($_POST['submitText'] === 'Abmelden') {
                    $teamParticipating = TeamParticipating::findTeamParticipating($turnierId, $subTeamId);
                    if (NULL !== $teamParticipating) {
                        $teamParticipating->delete();
                    }
                } else if ($_POST['submitText'] === 'Check-In') {
                    $teamParticipating = TeamParticipating::findTeamParticipating($turnierId, $subTeamId);
                    if (NULL !== $teamParticipating) {
                        $teamParticipating->checked_in = true;
                        $teamParticipating->update();
                    }
                } else if ($_POST['submitText'] === 'Check-Out') {
                    $teamParticipating = TeamParticipating::findTeamParticipating($turnierId, $subTeamId);
                    if (NULL !== $teamParticipating) {
                        $teamParticipating->checked_in = null;
                        $teamParticipating->update();
                    }
                }

            }

        }

        $tournamentList = Tournament::getTournament(1);

        return $this->render('tournamentsOverview',
            [
                'tournamentList' => $tournamentList,
                'siteLanguage' => $siteLanguage,
            ]
        );
    }

    /**
     * Rocket League Tournament Details
     *
     * @param null $id
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTournamentDetails($id = null)
    {
        $siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');
        $tournament = Tournament::getTournamentById($id);
        $ruleSet = $tournament->getRules();

        $participatingEntrys = $tournament->getParticipants()->all();

        $brackets = Bracket::getAllByTournamentFormatted($id);

        return $this->render('tournamentDetails',
            [
                'tournament' => $tournament,
                'ruleSet' => $ruleSet,
                'participatingEntrys' => $participatingEntrys,
                'brackets' => $brackets,
                'siteLanguage' => $siteLanguage,
            ]
        );
    }

    /**
     * Rocket League Create Brackets
     *
     * @param null $tournament_id
     * @return string
     */
    public function actionMovePlayerInBracket($tournament_id = null, $winner = null, $bracketId = null)
    {
        $run = false;
        if (Yii::$app->user->identity != NULL && Yii::$app->user->identity->getId() <= 4) {
            $run = true;
        }

        if (false === $run) {
            Alert::addError('Ungültige Aktion.');
            return $this->redirect('tournament-details?id=' . $tournament_id);
        }

        if ($winner != 1 && $winner != 2) {
            Alert::addError('Der Sieger muss gesetzt sein.');
            return $this->redirect('tournament-details?id=' . $tournament_id);
        }

        $bracket = Bracket::getById($bracketId);
        if ($bracket->tournament_id != $tournament_id) {
            Alert::addError('Das Bracket ist nicht in diesem Turnier.');
            return $this->redirect('tournament-details?id=' . $tournament_id);
        }

        $bracket->movePlayersNextRound($winner);

        $encounterConfirm = TournamentEncounterConfirm::getByFullKey($tournament_id, $bracketId);
        if ($encounterConfirm instanceof TournamentEncounterConfirm) {

            if (empty($encounterConfirm->player_1_confirm)) {
                $encounterConfirm->player_1_confirm = 0;
            }

            if (empty($encounterConfirm->player_2_confirm)) {
                $encounterConfirm->player_2_confirm = 0;
            }

            $encounterConfirm->update();

        } else {
            
            $encounterConfirm = new TournamentEncounterConfirm();
            $encounterConfirm->tournament_id = $tournament_id;
            $encounterConfirm->bracket_id = $bracketId;
            $encounterConfirm->player_1_confirm = 0;
            $encounterConfirm->player_2_confirm = 0;
            $encounterConfirm->save();

        }



        Alert::addSuccess('Bracket erfolgreich abgeschlossen.');

        return $this->redirect('tournament-details?id=' . $tournament_id);
    }

    /**
     * Close Bracket by Player
     */
    public function actionCloseBracket($tournament_id = null, $bracketId = null)
    {
        /** Sicherheitsbereich */
        if (Yii::$app->user->isGuest || Yii::$app->user->identity == null) {
            return $this->goHome();
        }

        $bracket = Bracket::getById($bracketId);
        if ($bracket->tournament_id != $tournament_id) {
            Alert::addError('Das Bracket ist nicht in diesem Turnier.');
            return $this->redirect('tournament-details?id=' . $tournament_id);
        }

        /** End of Sicherheitsbereich */

        // EncounterForm Yii-Style
        /*
        $model = EncounterDetailsForm::getEncounterForm($tournament_id, $bracketId);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            $winner = $model->winnerId;
            Alert::addSuccess('Alle daten erfolgreich eingetragen.');
            return $this->redirect('move-player-in-bracket?tournament_id=' . $tournament_id . '&winner' . $winner . '&bracketId=' . $bracketId);
        }
        */

        // Formular Captain-Style
        if (is_array($_POST) && isset($_POST['points'])) {

            foreach ($_POST['points'] as $gameRound => $playerArr) {
                
                $screenshotKey = 'screen_' . $gameRound;

                if (is_array($_FILES) && array_key_exists($screenshotKey, $_FILES)) {
                    
                    $filePathPng = $_FILES[$screenshotKey]['tmp_name'];

                    if (file_exists($filePathPng)) {

                        $filePathWebp = sys_get_temp_dir() . '/screen_' . $tournament_id . '_' . $bracketId . '_' . $gameRound . '.webp';

                        $cmd = escapeshellcmd('cwebp ' . $filePathPng . ' -o ' . $filePathWebp);
                        shell_exec($cmd);

                        $webp_content = file_get_contents($filePathWebp);

                        $encounterScreen = TournamentEncounterScreens::getByFullKey($tournament_id, $bracketId, $gameRound);
                        if (!$encounterScreen instanceof TournamentEncounterScreens) {
                            // neuer Screenshot
                            $encounterScreen = new TournamentEncounterScreens();
                            $encounterScreen->setBracketId($_POST['bracket_id']);
                            $encounterScreen->setTournamentId($_POST['tournament_id']);
                            $encounterScreen->setGameRound($gameRound);
                            $encounterScreen->setScreenshot($webp_content);
                            $encounterScreen->save();

                        } else {
                            // screenshot updaten
                            $encounterScreen->setScreenshot($webp_content);
                            $encounterScreen->update();

                        }

                    }

                }

                foreach ($playerArr as $playerId => $points) {
                    
                    $allowed = false;
                    foreach ($points as $key => $value) {
                        if (is_numeric($value)) {
                            $allowed = true;
                        }
                    }

                    if (false === $allowed) {
                        // wenn bei dem Spieler keine Werte ausgefüllt wurden, nicht in die DB reinschreiben.
                        continue;
                    }

                    $encounter = TournamentEncounter::getByFullKey($tournament_id, $bracketId, $gameRound, $playerId);

                    if (!$encounter instanceof TournamentEncounter) {
                        // neuer Encounter
                        $encounter = new TournamentEncounter();
                        $encounter->setBracketId($_POST['bracket_id']);
                        $encounter->setTournamentId($_POST['tournament_id']);
                        $encounter->setGameRound($gameRound);
                        $encounter->setPlayerId($playerId);
                        $encounter->setData($points);
                        $encounter->save();
                    } else {
                        // Daten überschreiben
                        $encounter->setData($points);
                        $encounter->update();
                    }

                }

                $encounterConfirm = TournamentEncounterConfirm::getByFullKey($tournament_id, $bracketId);
                if ($encounterConfirm instanceof TournamentEncounterConfirm) {
                    $encounterConfirm->player_1_confirm = NULL;
                    $encounterConfirm->player_2_confirm = NULL;
                    $encounterConfirm->update();
                }

                Alert::addSuccess('Screen and Results saved.<br>Please confirm to finish the bracket.');

            }

        }

        $player_left = NULL;
        $player_right = NULL;
        if ($bracket->team_1_id === NULL) {
            $player_left  = User::findIdentity($bracket->user_1_id);
            $player_right = User::findIdentity($bracket->user_2_id);

            $players_left = [$player_left];
            $players_right = [$player_right];
        } else {
            $player_left  = SubTeam::findIdentity($bracket->team_1_id);
            $player_right = SubTeam::findIdentity($bracket->team_2_id);

            $members_left = $player_left->getSubTeamMembers()->all();
            $members_right = $player_right->getSubTeamMembers()->all();

            foreach ($members_left as $key => $member) {
                if (NULL === $member) {
                    continue;
                }

                $user = $member->getUser()->one();
                if (NULL === $user) {
                    continue;
                }

                $players_left[] = $user;
            }

            foreach ($members_right as $key => $member) {
                if (NULL === $member) {
                    continue;
                }

                $user = $member->getUser()->one();
                if (NULL === $user) {
                    continue;
                }

                $players_right[] = $user;
            }

        }

        $encounterData = TournamentEncounter::getDataFromTournamentBracket($tournament_id, $bracketId);

        $encounterScreen = TournamentEncounterScreens::getScreensFromTournamentBracket($tournament_id, $bracketId);

        $editable = true;
        $winner = TournamentEncounter::getWinner($tournament_id, $bracketId, $bracket->getBestOf());
        $confirmable = (false == $winner) ? false : true;

        $user = Yii::$app->user->identity;

        // captain: rausfinden, ob er im linken oder rechten Team managen darf.
        $manageable1 = $bracket->isManageable($user, 1);
        $manageable2 = $bracket->isManageable($user, 2);
        $manageable = $manageable1 || $manageable2;

        // wenn eines der beiden werte false ist, ist es false.
        $editable = $editable && $manageable;
        $confirmable = $confirmable && $manageable;

        $encounterConfirm = TournamentEncounterConfirm::getByFullKey($tournament_id, $bracketId);

        if ($encounterConfirm instanceof TournamentEncounterConfirm) {

            $isConfirmeable = $encounterConfirm->isConfirmeable($tournament_id, $bracketId, $manageable1, $manageable2);
            $confirmable = $confirmable && $isConfirmeable;

            $isBothConfirmed = $encounterConfirm->isBothConfirmed($tournament_id, $bracketId);
            $editable = $editable && !$isBothConfirmed;
        }

        if ($user->getId() <= 4) {
            $editable = true;
        }

        return $this->render('editEncounterDetails',
            [
                'player_left' => $player_left,
                'player_right' => $player_right,
                'players_left' => $players_left,
                'players_right' => $players_right,
                'best_of' => $bracket->getBestOf(),
                'round' => $bracket->getTournamentRound(),
                'bracketID' => $bracket->getEncounterId(),
                'tournament_id' => $bracket->tournament_id,
                'bracket_id' => $bracketId,
                'encounterData' => $encounterData,
                'encounterScreen' => $encounterScreen,
                'editable' => $editable,
                'confirmable' => $confirmable,
            ]);
    }

    /**
     */
    public function actionConfirmResult($tournament_id = null, $bracket_id = null)
    {
        /** Sicherheitsbereich */
        if (Yii::$app->user->isGuest || Yii::$app->user->identity == null) {
            return $this->goHome();
        }

        $bracket = Bracket::getById($bracket_id);
        if ($bracket->tournament_id != $tournament_id) {
            Alert::addError('Das Bracket ist nicht in diesem Turnier.');
            return $this->redirect('tournament-details?id=' . $tournament_id);
        }

        /** End of Sicherheitsbereich */

        $user = Yii::$app->user->identity;

        // captain: rausfinden, ob er im linken oder rechten Team managen darf.
        $manageable1 = $bracket->isManageable($user, 1);
        $manageable2 = $bracket->isManageable($user, 2);

        $encounterConfirm = TournamentEncounterConfirm::getByFullKey($tournament_id, $bracket_id);
        if ($encounterConfirm instanceof TournamentEncounterConfirm) {

            if ($manageable1) {
                $encounterConfirm->player_1_confirm = $user->getId();
            }

            if ($manageable2) {
                $encounterConfirm->player_2_confirm = $user->getId();
            }

            $encounterConfirm->update();

        } else {
            
            $encounterConfirm = new TournamentEncounterConfirm();
            $encounterConfirm->tournament_id = $tournament_id;
            $encounterConfirm->bracket_id = $bracket_id;
            $encounterConfirm->player_1_confirm = ($manageable1) ? $user->getId() : NULL;
            $encounterConfirm->player_2_confirm = ($manageable2) ? $user->getId() : NULL;
            $encounterConfirm->save();

        }

        $isBothConfirmed = $encounterConfirm->isBothConfirmed($tournament_id, $bracket_id);
        if (true === $isBothConfirmed) {

            $winner = TournamentEncounter::getWinner($tournament_id, $bracket_id, $bracket->getBestOf());
            $bracket->movePlayersNextRound($winner);

            Alert::addSuccess('Bracket finished.');

        } else {
            Alert::addSuccess('Bracketresults confirmed.<br>Opponent has to confirm, to close the bracket.');
        }

        return $this->redirect('close-bracket?tournament_id=' . $tournament_id . '&bracketId=' . $bracket_id);

    }

    /**
     */
    public function actionBracketLiveStream($tournament_id = null, $bracketId = null)
    {
        $run = false;
        if (Yii::$app->user->identity != NULL && Yii::$app->user->identity->getId() <= 4) {
            $run = true;
        }

        if (false === $run) {
            Alert::addError('Ungültige Aktion.');
            return $this->redirect('tournament-details?id=' . $tournament_id);
        }

        $bracket = Bracket::getById($bracketId);
        if ($bracket->tournament_id != $tournament_id) {
            Alert::addError('Das Bracket ist nicht in diesem Turnier.');
            return $this->redirect('tournament-details?id=' . $tournament_id);
        }

        $bracket->changeLiveStream();

        return $this->redirect('tournament-details?id=' . $tournament_id);
    }

    /**
     * Rocket League Create Brackets
     *
     * @param null $tournament_id
     * @return string
     */
    public function actionCreateBrackets($tournament_id = null, $bracketId = null)
    {
        $run = false;
        if (Yii::$app->user->identity != NULL && Yii::$app->user->identity->getId() <= 4) {
            $run = true;
        }

        if (false === $run) {
            Alert::addError('Ungültige Aktion.');
            return $this->redirect('tournament-details?id=' . $tournament_id);
        }

        $brackets = Bracket::getAllByTournamentFormatted($tournament_id);
        if (count($brackets['winner']) > 0) {
            Bracket::clearForTournament($tournament_id);
        }

        $tournament = Tournament::getTournamentById($tournament_id);
        $bracketMode = $tournament->getBracketMode()->one();
        $participatingEntrys = $tournament->getParticipants()->all();
        foreach ($participatingEntrys as $key => $entry) {

            if ($entry instanceof User) {

                $participating = PlayerParticipating::findPlayerCheckedIn($tournament_id, $entry->getId());
                if (NULL === $participating) {
                    $participatingEntrys[$key] = NULL;
                }

            } else {

                $participating = TeamParticipating::findTeamCheckedIn($tournament_id, $entry->getId());
                if (NULL === $participating) {
                    $participatingEntrys[$key] = NULL;
                }

            }

        }

        $participatingEntrys = array_filter($participatingEntrys);

        if (NULL !== $bracketMode) {
            $doubleElimination = ($bracketMode->getName() == 'Double Elimination') ? true : false;

            $bracketArr = [];
            $looserPlayers = count($participatingEntrys) - 1;
            $teilnehmer = $participatingEntrys;

            // Zufällige Reihenfolge
            $randCount = mt_rand(10, 50);
            for ($r=0; $r < $randCount; $r++) { 
                shuffle($teilnehmer);
            }

            $playersPerRound = $this->createWinnerBracket($bracketArr, $tournament_id, $participatingEntrys, 1);
            if (true === $doubleElimination) {
                $this->createLooserBracket($bracketArr, $looserPlayers, $tournament_id, $playersPerRound/2, 1, false);
            }

            $this->setPlayersIntoBracket($bracketArr, $teilnehmer, $playersPerRound);
            $this->connectWinnerBrackets($bracketArr);
            if (true === $doubleElimination) {
                $this->createConnectFinale($bracketArr, $tournament_id);
                $countLooserBrackets = $this->connectLooserBrackets($bracketArr);
                $this->changeLooserRounds($bracketArr, $countLooserBrackets);
                $this->connectWinnerBracketsInLooser($bracketArr);
            }
            $this->moveFirstRoundTickets($bracketArr);
            if (true === $doubleElimination) {
                $this->stretchWinnerBracket($bracketArr, $tournament_id);
            }

        }

        $ruleSet = $tournament->getRules();

        Alert::addSuccess('Brackets erfolgreich angelegt.');

        return $this->redirect('tournament-details?id=' . $tournament_id);
    }

    public function actionBracketDetails($tournament_id = null, $bracketId = null)
    {
        $siteLanguage = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->getLanguage()->one() : Language::findByLocale('en-US');

        $bracket = Bracket::getById($bracketId);
        
        $player_left = NULL;
        $player_right = NULL;
        if ($bracket->team_1_id === NULL) {
            $player_left  = User::findIdentity($bracket->user_1_id);
            $player_right = User::findIdentity($bracket->user_2_id);

            $players_left = [$player_left];
            $players_right = [$player_right];
        } else {
            $player_left  = SubTeam::findIdentity($bracket->team_1_id);
            $player_right = SubTeam::findIdentity($bracket->team_2_id);

            $members_left = $player_left->getSubTeamMembers()->all();
            $members_right = $player_right->getSubTeamMembers()->all();

            foreach ($members_left as $key => $member) {
                if (NULL === $member) {
                    continue;
                }

                $user = $member->getUser()->one();
                if (NULL === $user) {
                    continue;
                }

                $players_left[] = $user;
            }

            foreach ($members_right as $key => $member) {
                if (NULL === $member) {
                    continue;
                }

                $user = $member->getUser()->one();
                if (NULL === $user) {
                    continue;
                }

                $players_right[] = $user;
            }

        }

        $encounterData = TournamentEncounter::getDataFromTournamentBracket($tournament_id, $bracketId);

        $encounterScreen = TournamentEncounterScreens::getScreensFromTournamentBracket($tournament_id, $bracketId);

        return $this->render('editEncounterDetails',
            [
                'player_left' => $player_left,
                'player_right' => $player_right,
                'players_left' => $players_left,
                'players_right' => $players_right,
                'best_of' => $bracket->getBestOf(),
                'round' => $bracket->getTournamentRound(),
                'bracketID' => $bracket->getEncounterId(),
                'tournament_id' => $bracket->tournament_id,
                'bracket_id' => $bracketId,
                'encounterData' => $encounterData,
                'encounterScreen' => $encounterScreen,
                'editable' => false,
                'submitable' => false,
            ]);
    }

    private function createWinnerBracket(&$bracketArr, $tournament_id, $teilnehmer, $bracketSizeInRound) {
        
        $playersPerRound = $bracketSizeInRound*2;

        for ($b=0; $b < $bracketSizeInRound; $b++) { 

            $bracket = new Bracket();
            $bracket->tournament_id = $tournament_id;
            $bracket->best_of = 3;
            $bracket->tournament_round = 1;
            $bracket->is_winner_bracket = true;
            $bracket->insert();
            
            $bracketArr[] = $bracket;

        }

        if (count($teilnehmer) <= $playersPerRound) {
            return $playersPerRound;
        }

        return self::createWinnerBracket($bracketArr, $tournament_id, $teilnehmer, $playersPerRound);

    }

    private function createLooserBracket(&$bracketArr, &$looserPlayers, $tournament_id, $playersPerWinnerRound, $bracketSizeInRound, $isVirtual) {

        $playersPerRound = ($isVirtual) ? $bracketSizeInRound*2 : $bracketSizeInRound;

        for ($b=0; $b < $bracketSizeInRound; $b++) { 

            $bracket = new Bracket();
            $bracket->tournament_id = $tournament_id;
            $bracket->best_of = 3;
            $bracket->tournament_round = 1;
            $bracket->is_winner_bracket = false;
            $bracket->insert();
            
            $bracketArr[] = $bracket;

            if (!$isVirtual) {
                $looserPlayers--;
            }

        }

        if ($playersPerRound >= $playersPerWinnerRound) {
            return;
        }

        self::createLooserBracket($bracketArr, $looserPlayers, $tournament_id, $playersPerWinnerRound, $playersPerRound, !$isVirtual);
    }

    private function setPlayersIntoBracket(&$bracketArr, $teilnehmer, $playersPerRound) {

        $initialLimbs = $playersPerRound / 2;
        $countSingle = $playersPerRound - count($teilnehmer);

        $bracket = reset($bracketArr);

        for ($l=0; $l < $initialLimbs; $l++) { 

            $bracket->encounter_id = $l+1;
            $bracket->tournament_round = 1;
            $bracket->setSpieler(array_shift($teilnehmer));
            if (0 === $countSingle) {
                $bracket->setSpieler(array_shift($teilnehmer));
            } else {
                $countSingle--;
            }

            $bracket->update();

            $bracket = next($bracketArr);

        }

    }

    private function connectWinnerBrackets(&$bracketArr) {

        $initBracket = $bracketArr;

        $bracket1 = reset($initBracket);
        $bracket2 = next($initBracket);

        $id = 1;

        foreach ($bracketArr as $key => $bracket) {
            
            $encounterId = $bracket->getEncounterId();
            if ($encounterId !== NULL) {
                $id = $encounterId + 1;
                continue;
            }

            $bracket->encounter_id = $id;
            $bracket->tournament_round = $bracket1->getTournamentRound() + 1;
            $bracket->update();

            $bracket1->winner_bracket = $bracket->getId();
            $bracket2->winner_bracket = $bracket->getId();

            $bracket1->update();
            $bracket2->update();

            $bracket1 = next($initBracket);
            $bracket2 = next($initBracket);

            $id++;

            if (false !== $bracket1 && !$bracket1->getIsWinnerBracket()) {
                break;
            }

            if (false !== $bracket2 && !$bracket2->getIsWinnerBracket()) {
                break;
            }

        }
    }

    private function connectLooserBrackets(&$bracketArr) {

        $id = 0;

        foreach ($bracketArr as $key => $bracket) {
            
            $encounterId = $bracket->getEncounterId();
            if ($encounterId !== NULL) {
                $id = $encounterId + 1;
                continue;
            }

            $bracket->encounter_id = $id;
            $bracket->tournament_round = 1;
            $bracket->update();

            $id++;

        }

        $initBracketRevers = $bracketArr;
        $looserBracket = end($initBracketRevers);

        $initBracket = $bracketArr;
        $winnerBracket = reset($initBracket);
        while ($winnerBracket->getIsWinnerBracket()) {
            $winnerBracket = next($initBracket);
        }
        $winnerBracket = prev($initBracket);

        $countIns = 1;

        while (false !== $looserBracket && !$looserBracket->getIsWinnerBracket()) {

            for ($c=1; $c<=$countIns; $c++) {

                $winnerBracket->looser_bracket = $looserBracket->getId();
                $winnerBracket->update();
                $winnerBracket = prev($initBracket);

                $looserBracket = prev($initBracketRevers);

            }

            for ($c=1; $c<=$countIns; $c++) {
                $looserBracket = prev($initBracketRevers);
            }

            $countIns*= 2;

        }

        $countIns/= 2;

        if (false === $winnerBracket) {
            return;
        }

        for ($c=1; $c<=$countIns; $c++) {
            $looserBracket = next($initBracketRevers);
        }

        $countLooserBrackets = 0;

        while (false !== $looserBracket && !$looserBracket->getIsWinnerBracket()) {
            $winnerBracket->looser_bracket = $looserBracket->getId();
            $winnerBracket->update();
            $winnerBracket = prev($initBracket);

            $winnerBracket->looser_bracket = $looserBracket->getId();
            $winnerBracket->update();
            $winnerBracket = prev($initBracket);

            $looserBracket = prev($initBracketRevers);
            $countLooserBrackets++;
        }

        return $countLooserBrackets;
    }

    private function changeLooserRounds(&$bracketArr, $countLooserBrackets) {

        $countFirstLooserBrackets = 0;
        $round = 0;

        foreach ($bracketArr as $key => $bracket) {

            if (!$bracket->getIsWinnerBracket()) {
                continue;
            }

            if ($bracket->getTournamentRound() !== 1) {
                continue;
            }

            $looserBracket = $bracket->getLooserBracket()->one();
            if (NULL === $looserBracket) {
                continue;
            }

            $round = $bracket->getTournamentRound() + 1;
            $looserBracket->tournament_round = $round;
            $looserBracket->update();
            $countFirstLooserBrackets++;
        }

        $countFirstLooserBrackets/= 2;

        $counter = 0;
        $bracket = reset($bracketArr);
        while ($bracket->getIsWinnerBracket()) {
            $bracket = next($bracketArr);
        }
        while ($counter < $countFirstLooserBrackets) {
            $bracket = next($bracketArr);
            $counter++;
        }
        $isVirtual = false;
        $counter = 0;
        $round++;
        while (false !== $bracket) {

            $bracket->tournament_round = $round;
            $bracket->update();
            $bracket = next($bracketArr);
            $counter++;

            if ($counter === $countFirstLooserBrackets) {
                $isVirtual = !$isVirtual;
                if ($isVirtual && $countFirstLooserBrackets === 1) {
                    break;
                }
                $countFirstLooserBrackets = ($isVirtual) ? $countFirstLooserBrackets/2 : $countFirstLooserBrackets;
                $counter = 0;
                $round++;
            }
        }
    }

    private function connectWinnerBracketsInLooser(&$bracketArr) {
        
        $initBracket = $bracketArr;

        $winnerBrackets = reset($initBracket);
        while ($winnerBrackets->getIsWinnerBracket()) {
            $winnerBrackets = next($initBracket);
        }
        $looserBracket = $winnerBrackets;

        $isVirtual = true;

        foreach ($bracketArr as $key => $bracket) {
            
            if ($bracket->getIsWinnerBracket()) {
                continue;
            }

            $bracketRefs = count($bracket->getBracketRefs());

            for ($b=$bracketRefs; $b<2; $b++) {

                $looserBracket->winner_bracket = $bracket->getId();
                $looserBracket->update();

                $looserBracket = next($initBracket);
            }
        }
    }

    private function moveFirstRoundTickets(&$bracketArr) {
        
        foreach ($bracketArr as $key => $bracket) {
            
            if ($bracket->getTournamentRound() > 1) {
                continue;
            }

            $participants = $bracket->getParticipants();
            if ($participants[1] !== NULL) {
                continue;
            }

            $bracket->movePlayersNextRound(1);
        }
    }

    private function stretchWinnerBracket(&$bracketArr) {

        foreach ($bracketArr as $key => $bracket) {

            if (!$bracket->getIsWinnerBracket()) {
                continue;
            }

            $tRound = $bracket->getTournamentRound();

            if ($tRound == 1 || $tRound == 2) {
                continue;
            }

            $diff = $tRound - 2;
            $newRound = $tRound + $diff;
            $bracket->tournament_round = $newRound;
            $bracket->update();

        }

    }

    private function createConnectFinale(&$bracketArr, $tournament_id) {

        $finale1 = new Bracket();
        $finale1->tournament_id = $tournament_id;
        $finale1->encounter_id = count($bracketArr) + 1;
        $finale1->best_of = 5;
        $finale1->tournament_round = 998;
        $finale1->is_winner_bracket = true;
        $finale1->insert();

        $finale2 = new Bracket();
        $finale2->tournament_id = $tournament_id;
        $finale2->encounter_id = count($bracketArr) + 2;
        $finale2->best_of = 5;
        $finale2->tournament_round = 999;
        $finale2->is_winner_bracket = true;
        $finale2->insert();

        $finale1->winner_bracket = $finale2->getId();
        $finale1->looser_bracket = $finale2->getId();
        $finale1->update();

        $highestWinnerRound = 0;
        $highestWinnerBracket = NULL;
        foreach ($bracketArr as $key => $bracket) {

            if (!$bracket->getIsWinnerBracket()) {
                continue;
            }

            if ($highestWinnerRound < $bracket->getTournamentRound()) {
                $highestWinnerRound = $bracket->getTournamentRound();
                $highestWinnerBracket = $bracket;
            }
        }

        $highestWinnerBracket->winner_bracket = $finale1->getId();
        $highestWinnerBracket->update();

        $lastBracket = end($bracketArr);
        $lastBracket->winner_bracket = $finale1->getId();
        $lastBracket->update();
    }
}