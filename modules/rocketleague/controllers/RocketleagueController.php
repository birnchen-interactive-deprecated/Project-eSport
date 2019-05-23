<?php
/**
 * Created by PhpStorm.
 * User: Pierre Köhler
 * Date: 03.04.2019
 * Time: 16:11
 */

namespace app\modules\rocketleague\controllers;

use app\components\BaseController;

use app\modules\teams\models\SubTeam;
use app\modules\tournaments\models\Tournament;
use app\modules\tournaments\models\PlayerParticipating;
use app\modules\tournaments\models\TeamParticipating;
use app\modules\tournamenttrees\models\Bracket;

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

        return $this->render('teamsOverview',
            [
                'teamHierarchy' => $teamHierarchy,
            ]
        );
    }

    /**
     * Rocket League Tournament
     */
    public function actionTournaments()
    {
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
        $tournament = Tournament::getTournamentById($id);
        $ruleSet = $tournament->getRules();

        $participatingEntrys = $tournament->getParticipants()->all();

        // $brackets = Bracket::getAllByTournament($id);

        return $this->render('tournamentDetails',
            [
                'tournament' => $tournament,
                'ruleSet' => $ruleSet,
                'participatingEntrys' => $participatingEntrys
            ]
        );
    }

    /**
     * Rocket League Create Brackets
     *
     * @param null $tournament_id
     * @return string
     */
    public function actionCreateBrackets($tournament_id = null)
    {
        $tournament = Tournament::getTournamentById($tournament_id);
        $bracketMode = $tournament->getBracketMode()->one();
        $participatingEntrys = $tournament->getParticipants()->all();

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
            $this->connectBrackets($bracketArr);

        }

        $ruleSet = $tournament->getRules();


        return $this->render('tournamentDetails',
            [
                'tournament' => $tournament,
                'ruleSet' => $ruleSet,
                'participatingEntrys' => $participatingEntrys
            ]
        );
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

    private function connectBrackets(&$bracketArr) {

        $initBracket = $bracketArr;

        // Winner Brackets
        $bracket1 = reset($initBracket);
        $bracket2 = next($initBracket);

        $id = 0;

        foreach ($bracketArr as $key => $bracket) {
            
            $id = $bracket->getEncounterId();
            if ($id !== NULL) {
                $id++;
                continue;
            }

            $bracket->encounter_id = $id;
            $bracket->tournament_round = $bracket[$bracket1]->getTournamentRound() + 1;
            $bracket->update();

            $bracket1->winner_bracket = $bracket->getId();
            $bracket2->winner_bracket = $bracket->getId();

            $bracket1->update();
            $bracket2->update();

            $bracket1 = next($initBracket);
            $bracket2 = next($initBracket);

            $id++;

            if (!$bracket[$bracket1]->isWinnerBracket()) {
                break;
            }

            if (false !== $bracket[$bracket2] && !$bracket[$bracket2]->isWinnerBracket()) {
                break;
            }

        }

        // Looser Brackets
        $bracket1 = reset($initBracket);
        $bracket2 = next($initBracket);

        foreach ($bracketArr as $key => $bracket) {
            
            $id = $bracket->getEncounterId();
            if ($id !== NULL) {
                $id++;
                continue;
            }

            $bracket->encounter_id = $id;
            $bracket->tournament_round = 1;
            $bracket->update();

            $bracket1->looser_bracket = $bracket->getId();
            $bracket2->looser_bracket = $bracket->getId();

            $bracket1->update();
            $bracket2->update();

            $bracket1 = next($initBracket);
            $bracket2 = next($initBracket);

            $id++;

        }

    }

}