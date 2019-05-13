<?php

/* @var $this yii\web\View *
 * @var $profilePicModel \app\modules\core\models\ProfilePicForm
 * @var $model app\modules\core\models\User
 * @var $userInfo array
 * @var $games array
 * @var $mainTeams array
 * @var $subTeams array
 */

use app\modules\admin\Module;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

\app\modules\user\assets\UserAsset::register($this);

/** Browser Title */
$this->title = $model->username . '\'s Player profile';

/** Site Canonicals */
$this->registerLinkTag(['rel' => 'canonical', 'href' => 'https://project-esport.gg' . Yii::$app->request->url]);

/** twitter/facebook/google Metatag */
Yii::$app->MetaClass->writeMetaUser($this, $model, $userInfo['nationality']);

/** $synonym = ($gender_id == 1) ? 'synonym_m' : ($gender_id == 2) ? 'synonym_w' : 'synonym_d'; */
?>

<div class="site-account">
    <!-- Avatar Panel -->
    <div class="col-lg-3 avatarPanel">
        <img class="avatar-logo" src="<?= $userInfo['playerImage']; ?>.webp" alt=""
             onerror="this.src='<?= $userInfo['playerImage']; ?>.png'">
        <?php if ($userInfo['isMySelfe']) : ?>
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
            <?= Html::submitButton(Yii::t('app', 'upload')); ?>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>

    <!-- Personal User Informations -->
    <div class="col-lg-7 playerPanel">
        <!-- Header with User id and Nationality -->
        <div class="header">
            <img class="nationality-logo" src="<?= $userInfo['nationalityImg']; ?>.webp" alt=""
                 onerror="this.src='<?= $userInfo['nationalityImg']; ?>.png'">
            <span class="username"><?= $model->username; ?></span>
            <span class="userid">ID:<?= $model->id ?></span>
        </div>

        <!-- Personal user Informations -->
        <div class="userBody">
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg"><?= \app\modules\user\Module::t('account', 'name', $userInfo['language']->locale) ?>
                    :
                </div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $model->pre_name . ' ' . $model->last_name; ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'alias', $userInfo['language']->locale) ?>
                    :
                </div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $model->username; ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'member_since', $userInfo['language']->locale) ?>
                    :
                </div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $userInfo['memberSince']; ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'age_gender', $userInfo['language']->locale) ?>
                    :
                </div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $userInfo['age'] . " / " . $userInfo['gender']->getName(); ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'nationality', $userInfo['language']->locale) ?>
                    :
                </div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context">
                    <img class="nationality-logo" src="<?= $userInfo['nationalityImg']; ?>.webp" alt=""
                         onerror="this.src='<?= $userInfo['nationalityImg']; ?>.png'">
                    <?= $userInfo['nationality']->getName(); ?>
                </div>
            </div>

            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'language', $userInfo['language']->locale) ?>:</div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context">
                    <img class="nationality-logo" src="<?= $userInfo['nationalityImg']; ?>.webp" alt=""
                         onerror="this.src='<?= $userInfo['nationalityImg']; ?>.png'">
                    <?= $userInfo['language']->getName(); ?>
                </div>
            </div>

            <?php if(!empty($model->twitter_account)): ?>
                <div class="entry clearfix">
                    <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'twitter_account', $userInfo['language']->locale) ?>:</div>
                    <div class="col-xs-7 col-sm-9 col-lg-9 context">
                        <?= Html::a('@' . $model->twitter_account, 'https://twitter.com/' . $model->twitter_account, ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'twitter', 'label' => 'twitter']); ?>   
                    </div>
                </div>
            <?php endif; ?>

            <?php if(!empty($model->twitter_channel)): ?>
                <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'twitter_channel', $userInfo['language']->locale) ?>:</div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context">
                    <?= Html::a('#' . $model->twitter_channel, 'https://twitter.com/hashtag/' . $model->twitter_channel . '?f=tweets&vertical=default', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'twitter', 'label' => 'twitter']); ?>   
                </div>
            </div>
            <?php endif; ?>

            <?php if(!empty($model->discord_id)): ?>
                <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'discord_account', $userInfo['language']->locale) ?>:</div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context">
                    <?= $model->discord_id; ?>  
                </div>
            </div>
            <?php endif; ?>

            <?php if(!empty($model->discord_server)): ?>
                <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?= \app\modules\user\Module::t('account', 'discord_server', $userInfo['language']->locale) ?>:</div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context">
                    <?= Html::a($model->discord_server, 'https://discordapp.com/invite/' . $model->discord_server, ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'twitter', 'label' => 'twitter']); ?>   
                </div>
            </div>
            <?php endif; ?>

            

            <!-- User games/Platforms and id's -->
            <div class="clearfix">
                <div class="col-lg-12 gameHeader">
                    <?= \app\modules\user\Module::t('account', 'games', $userInfo['language']->locale) ?>
                    <?php if ($userInfo['isMySelfe']) : ?>
                        <?= Html::a('(add)', ['/user/add-game-id', 'id' => $model->id]); ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="gameBody clearfix">
                <div class="col-lg-12">
                    <?php foreach ($games as $key => $game) : ?>
                        <div class="gameRow">
                            <img class="platform-logo" src="<?= $game['platform']; ?>.webp" alt="" onerror="this.src='<?= $game['platform']; ?>.png'">
                            <img class="game-logo" src="<?= $game['gameImg']; ?>.webp" alt="" onerror="this.src='<?= $game['gameImg']; ?>.png'">
                            <?php if ($game['visible'] || $userInfo['isMySelfe']) : ?>
                                <?= $game['playerId']; ?>
                            <?php endif; ?>
                            <?php if ($userInfo['isMySelfe']): ?>
                                <?php
                                    echo Html::a('',
                                        [
                                            "toggle-visibility",
                                            "gameId" => $game['gameId'],
                                            "platformId" => $game['platformId']
                                        ],
                                        ['class' => $game['visible'] == 1 ? "glyphicon glyphicon-eye-open" : "glyphicon glyphicon-eye-close",
                                            'title' => $game['visible'] == 1 ? "Verstecken" : "Sichtbar machen"
                                        ]
                                    )
                                ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Teams where the user is member -->
            <div class="clearfix">
                <div class="col-lg-12 teamHeader">My Team & Sub-Teams</div>
            </div>
            <div class="teamBody clearfix">
                <div class="col-xs-12 col-sm-6">
                    <div class="mainTeam">Main Team:</div>
                    <?php foreach ($mainTeams as $key => $mainTeam): ?>
                        <div class="teamEntry clearfix">
                            <div class="col-lg-12">
                                <?= Html::a($mainTeam['team']->getName(), ['/teams/team-details', 'id' => $mainTeam['team']->getId()]); ?>
                                <?= ($mainTeam['owner']) ? '(owner)' : '(member)'; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="mainTeam">Sub Teams:</div>
                    <?php foreach ($subTeams as $key => $subTeam): ?>
                        <div class="teamEntry clearfix">
                            <div class="col-lg-12"><?= Html::a($subTeam['team']->getTeamName(), ['/teams/sub-team-details', 'id' => $subTeam['team']->getId()]) . " (" . $subTeam['team']->getTournamentMode()->one()->getName() . ")"; ?>
                                <?= ($subTeam['owner']) ? '(Captain)' : (($subTeam['isSub']) ? '(substitute)' : '(player)'); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>


            </div>

        </div>
    </div>
</div>