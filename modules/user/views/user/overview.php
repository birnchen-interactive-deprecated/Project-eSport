<?php

/* @var $this yii\web\View
 * @var $pagination array
 * @var $soretedPaginatedUsers array
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;

\app\modules\user\assets\UserAsset::register($this);

$this->title = 'Player Overview';
?>
<div class="site-player-overview">
	<?php foreach ($soretedPaginatedUsers as $user) : ?>
    	<?php
    		$userImage = Yii::$app->HelperClass->checkImage('/images/userAvatar/', $user->getId());
            $username = $user->getUsername();
            $userId = $user->getId();
            $mainTeams = $user->getMainTeams();
            $subTeams = $user->getAllSubTeamsWithMembers();
            $userGames = $user->getGames()->all();

	        /** @var $games array */
	        $games = [];
	        foreach ($userGames as $userGame) {
	            $games[] = [
	                'gameId' => $userGame->getGameId(),
	                'platformId' => $userGame->getPlatformId(),
	                'gameImg' => Yii::$app->HelperClass->checkImage('/images/gameLogos/', $userGame->getGameId()),
	                'platform' => Yii::$app->HelperClass->checkImage('/images/platforms/', $userGame->getPlatformId()),
	                'playerId' => $userGame->getPlayerId(),
	                'visible' => $userGame->getIsVisible()
	            ];
	        }

	        usort($games, function ($a, $b) {
	            return [$a['platformId'], $a['gameId']] <=> [$b['platformId'], $b['gameId']];
	        });
	        ?>
        <div class="playerRow clearfix">
        	<!-- summe Y aller col-lg-X darf 12 nicht ueberschreiten, sonst bricht es um -->
        	<div class="col-lg-1"><img class="userAvatar" src="<?= $userImage; ?>.webp" alt=""
                         onerror="this.src='<?= $userImage; ?>.png'"></div>
	        <div class="col-lg-2"><?= Html::a($username, ['/user/details', 'id' => $userId]); ?></div>
	        <div class="col-lg-2">
	        	<?php foreach ($mainTeams as $key => $mainTeam): ?>
                    <?= Html::a($mainTeam['team']->getName(), ['/teams/team-details', 'id' => $mainTeam['team']->getId()]); ?><br>
                    <?= ($mainTeam['owner']) ? '(owner)' : '(member)'; ?><br>
                <?php endforeach; ?>
	        </div>
	        <div class="col-lg-2">
	        	<?php foreach ($subTeams as $key => $subTeam): ?>
                    <?= Html::a($subTeam['team']->getTeamName(), ['/teams/sub-team-details', 'id' => $subTeam['team']->getId()]) . " (" . $subTeam['team']->getTournamentMode()->one()->getName() . ")"; ?><br>
                    <?= ($subTeam['owner']) ? '(Captain)' : (($subTeam['isSub']) ? '(substitute)' : '(player)'); ?><br>
                <?php endforeach; ?>
	        </div>
	        <div class="col-lg-3">
	        	<?php foreach ($games as $key => $game) : ?>
	        		<div>
                    <img class="platform-logo" src="<?= $game['platform']; ?>.webp" alt="platform" onerror="this.src='<?= $game['platform']; ?>.png'">
                    <img class="game-logo" src="<?= $game['gameImg']; ?>.webp" alt="game" onerror="this.src='<?= $game['gameImg']; ?>.png'">
                    <?php if ($game['visible']) : ?>
                        <?= $game['playerId']; ?>
                    <?php endif; ?>
                	</div>
                <?php endforeach; ?>
	        </div>
	        <div class="col-lg-2"><!-- Container 2 --></div>
	        <div class="col-lg-1"><!-- Container 3 --></div>
		</div>
	<?php endforeach; ?>

	<?php
		echo LinkPager::widget([
    		'pagination' => $pagination,
		]);
	?>
</div>