<?php

/* @var $this yii\web\View
 * @var $pagination array
 * @var $sortedPaginatedUsers array
 * @var $isMainTeamManager array
 * @var $siteLanguage
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;

use yii\bootstrap\ActiveForm;

\app\modules\user\assets\UserAsset::register($this);

$this->title = 'Player Overview';
?>
<div class="site-player-overview">
	<div class="playerRow clearfix">
        	<!-- summe Y aller col-lg-X darf 12 nicht ueberschreiten, sonst bricht es um -->
        	<div class="col-lg-1"><?= \app\modules\user\Module::t('overview', 'avatar', $siteLanguage->locale) ?></div>
	        <div class="col-lg-2"><?= \app\modules\user\Module::t('overview', 'username', $siteLanguage->locale) ?></div>
	        <div class="col-lg-2"><?= \app\modules\user\Module::t('overview', 'mainteam', $siteLanguage->locale) ?></div>
	        <div class="col-lg-2"><?= \app\modules\user\Module::t('overview', 'subteam', $siteLanguage->locale) ?></div>
	        <div class="col-lg-2"><?= \app\modules\user\Module::t('overview', 'games', $siteLanguage->locale) ?></div>
	        <?php if($isMainTeamManager) : ?>
	        	<div class="col-lg-2"><?= \app\modules\user\Module::t('overview', 'invite', $siteLanguage->locale) ?></div>
	        	<div class="col-lg-1"><!-- Container 3 --></div>
	        <?php else: ?>
	        	<div class="col-lg-2"><!-- Container 2 --></div>
	        	<div class="col-lg-1"><!-- Container 3 --></div>
	    	<?php endif; ?>
		</div>
	<?php foreach ($sortedPaginatedUsers as $index => $user) : ?>
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
	        <div class="col-lg-2">
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
	        <?php if($isMainTeamManager): ?>
	        	<div class="col-lg-2">
	        		<?php foreach ($isMainTeamManager as $mainTeamInvitabel) : ?>
	        			<?php if(!$user->getIsMainTeammember($mainTeamInvitabel->getId())) : ?>
	        				<?php if(!$user->getIsInvited($mainTeamInvitabel->getId())) : ?>
			        			<?php
				        			echo Html::a('',
				                        [
				                            "invite-to-team",
				                            "userId" => $userId,
				                            "teamId" => $mainTeamInvitabel->getId()
				                        ],
				                        ['class' => "glyphicon glyphicon-link",
				                            'title' => "Invite"
				                        ]
			                    	)
		                    	?>
		                    	<?= $mainTeamInvitabel->getName(); ?><br>
	                    	<?php else : ?>
	                    		<?php
				        			echo Html::a('',
				                        [
				                            "withdrawn-invite",
				                            "userId" => $userId,
				                            "teamId" => $mainTeamInvitabel->getId()
				                        ],
				                        ['class' => "glyphicon glyphicon-ok-sign",
				                            'title' => "Withdrawn Invitation"
				                        ]
			                    	)
		                    	?>
	                    		<?= ' ' . $mainTeamInvitabel->getName(); ?><br>
	                    	<?php endif; ?>
                    	<?php endif; ?>
	        		<?php endforeach; ?>
	        		
	        	</div>
	        <?php else: ?>
	        	<div class="col-lg-2"><!-- Container 2 --></div>
	        	<div class="col-lg-1"><!-- Container 3 --></div>
	    	<?php endif; ?>
		</div>
	<?php endforeach; ?>

	<?php
		echo LinkPager::widget([
    		'pagination' => $pagination,
		]);
	?>
	<script type="text/javascript">
		function getTeamId() {
			return $('#teamSelect').val();
		}
	</script>
</div>