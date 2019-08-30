<?php
/**
 * Created by PhpStorm.
 * User: Pierre Köhler
 * Date: 18.03.2019
 * Time: 09:15
 */

/* @var $this yii\web\View *
 * @var $profilePicModel ProfilePicForm
 * @var $teamDetails array
 * @var $teamInfo array
 * @var $subTeams array
 */

use app\modules\core\models\ProfilePicForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

\app\modules\teams\assets\TeamsAsset::register($this);

/* Browser Title */
$this->title = $teamDetails->getName() . '\'s Team profile';

/* Site Canonicals */
$this->registerLinkTag(['rel' => 'canonical', 'href' => 'https://project-esport.gg' . Yii::$app->request->url]);

/* twitter/facebook/google Metatags */
Yii::$app->MetaClass->writeMetaMainTeam($this, $teamDetails, $this->title);

?>

<div class="site-team-details">
    <div class="col-lg-3 avatarPanel">
        <img class="avatar-logo" src="<?= $teamInfo['teamImage']; ?>.webp" alt="<?=\app\modules\teams\Module::t('teams', 'teamLogo')?>" aria-label="<?=\app\modules\teams\Module::t('teams', 'teamLogo')?>"
             onerror="this.src='<?= $teamInfo['teamImage']; ?>.png'">

        <?php if ($teamInfo['isOwner'] || $teamInfo['isDeputy']) : ?>
            <?php $form = ActiveForm::begin([
                'id' => 'profile-pic-form',
                // 'layout' => 'horizontal',
                'options' => ['enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                    'template' => "<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>"
                ],
            ]); ?>
            <?= $form->field($profilePicModel, 'id')->hiddenInput()->label(false); ?>
            <?= $form->field($profilePicModel, 'file')->fileInput() ?>
            <?= Html::submitButton(\app\modules\teams\Module::t('teams', 'upload')); ?>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>


    <div class="col-lg-6 teamPanel">

        <div class="header">
            <?= Html::img($teamInfo['nationalityImg'], ['class' => 'nationality-logo']); ?>
            <span class="teamname"><?= $teamDetails->getName(); ?></span>
            <span class="teamid">id: <?= $teamDetails->getId(); ?></span>
            <?php if ($teamInfo['isOwner'] || $teamInfo['isDeputy']) : ?>
                <?php
                    echo Html::a('',
                        [
                            "edit-details",
                            "id" => $teamDetails->getId(),
                            "isSub" => false
                        ],
                        ['class' => "glyphicon glyphicon-pencil",
                            'title' => "Edit Details"
                        ]
                    )
                ?>
            <?php endif; ?>
        </div>
        <div class="teamInfos">
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'name')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $teamDetails->getName(); ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'shortcode')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $teamDetails->getShortCode(); ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'team_captain')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= Html::a($teamDetails->getOwner()->one()->getUsername(), ['/user/details', 'id' => $teamDetails->getOwnerId()]); ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'member_since')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $teamInfo['memberSince']; ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'nationality')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= Html::img($teamInfo['nationalityImg'], ['class' => 'nationality-logo']); ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'description')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $teamDetails->getTeamDescription() ?></div>
            </div>
        </div>
        <div class="entry entrySubTeams clearfix">
            <div class="col-xs-5 col-sm-3 col-lg-3">
                <?=\app\modules\teams\Module::t('teams', 'teams')?>
                <?php if ($teamInfo['isOwner'] || $teamInfo['isDeputy']) : ?>
                    <?php
                        echo Html::a('',
                            [
                                "add-sub-team",
                                'teamId' => $teamDetails->getId()
                            ],
                            ['class' => "glyphicon glyphicon-new-window",
                                'title' => "Add Team"
                            ]
                        )
                    ?>
                <?php endif; ?>
            </div>
            <div class="col-xs-7 col-sm-9 col-lg-9 context">
                <?php foreach ($subTeams as $tournamentMode => $subTeamsPerMode): ?>
                    <div class="col-lg-12 tournamentMode clearfix"><?= $tournamentMode; ?></div>
                    <?php foreach ($subTeamsPerMode as $subTeam): ?>

                        <div class="col-lg-6 subTeam">
                            <?= Html::a($subTeam->getTeamName(), ['/teams/sub-team-details', 'id' => $subTeam->getId()]); ?>
                            <?php if ($teamInfo['isOwner'] || $teamInfo['isDeputy']) : ?>
                                <?php
                                    echo Html::a('',
                                        [
                                            "edit-details",
                                            "id" => $subTeam->getId(),
                                            "isSub" => true
                                        ],
                                        ['class' => "glyphicon glyphicon-pencil",
                                            'title' => "Edit Details"
                                        ]
                                    )
                                ?>
                            <?php endif; ?>
                        </div>

                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="entry entryMembers clearfix">
            <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'clan_member')?></div>
            <div class="col-xs-7 col-sm-9 col-lg-9 context">
                <?php foreach($teamDetails->getTeamMemberWithOwner() as $userKey => $user): ?>
                    <?php
                        $username = $user->getUsername();
                        $userId = $user->getId();
                    ?>
                    <div class="col-lg-4 teamMembers"><?= Html::a($username, ['/user/details', 'id' => $userId]); ?>
                        <?php if ($teamInfo['isOwner'] || $teamInfo['isDeputy']) : ?>
                        <?php
                            echo Html::a('',
                                [
                                    "delete-member",
                                    "teamId" => $teamDetails->getId(),
                                    "userId" => $userId,
                                    "isSub" => false
                                ],
                                ['class' => "glyphicon glyphicon-remove",
                                    'title' => "Remove Player"
                                ]
                            )
                        ?>
                    <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <?php if(!empty($teamDetails->twitter_account)): ?>
            <?= Html::a('Tweets by ' . $teamDetails->twitter_account, 'https://twitter.com/' . $teamDetails->twitter_account . '?ref_src=twsrc%5Etfw', ['class' => 'twitter-timeline', 'target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'twitter-timeline', 'label' => 'twitter-timeline', 'data-lang' => 'en', 'data-height' => '400', 'data-theme' => 'light']); ?>
        <?php endif; ?>
    </div>
    
</div>
