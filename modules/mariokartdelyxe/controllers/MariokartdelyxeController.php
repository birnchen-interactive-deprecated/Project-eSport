<?php
/**
 * Created by PhpStorm.
 * User: Pierre Köhler
 * Date: 03.04.2019
 * Time: 16:11
 */

namespace app\modules\mariokartdelyxe\controllers;

use Yii;

use app\widgets\Alert;

use app\components\BaseController;

use app\modules\teams\models\SubTeam;
use app\modules\tournaments\models\Tournament;
use app\modules\tournaments\models\PlayerParticipating;
use app\modules\tournaments\models\TeamParticipating;
use app\modules\tournamenttrees\models\Bracket;

use app\modules\tournamenttrees\models\formModels\EncounterDetailsForm;

use app\modules\user\models\User;
use app\modules\user\models\Language;

class MariokartdelyxeController extends BaseController
{
	/**
     * Mario Kart 8 Delyxe News Page
     *
     * @return string
     */
    public function actionNews()
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/../modules/rss_feeds/mariokartdelyxe/mk8d_feed.xml');

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
        $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/../modules/rss_feeds/mariokartdelyxe/mk8d_feed.xml');

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
        $teamHierarchy = SubTeam::getTeamHierarchyByGame(3);
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

        $tournamentList = Tournament::getTournament(3);

        return $this->render('tournamentsOverview',
            [
                'tournamentList' => $tournamentList,
                'siteLanguage' => $siteLanguage,
            ]
        );
    }
}