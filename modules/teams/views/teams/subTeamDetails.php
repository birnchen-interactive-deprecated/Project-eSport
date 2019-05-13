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
 */

use app\modules\core\models\ProfilePicForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

\app\modules\teams\assets\TeamsAsset::register($this);

/* Browser Title */
$this->title = $teamDetails->getTeamName() . '\'s Sub Team profile';

/* Site Canonicals */
$this->registerLinkTag(['rel' => 'canonical', 'href' => 'https://project-esport.gg' . Yii::$app->request->url]);

/* twitter/facebook/google Metatags */
Yii::$app->MetaClass->writeMetaMainTeam($this, $teamDetails, $this->title);

?>

<div class="site-sub-team-details">
    <div class="col-lg-3 avatarPanel">
        <img class="avatar-logo" src="<?= $teamInfo['teamImage']; ?>.webp" alt="<?=\app\modules\teams\Module::t('teams', 'teamLogo')?>" aria-label="<?=\app\modules\teams\Module::t('teams', 'teamLogo')?>"
             onerror="this.src='<?= $teamInfo['teamImage']; ?>.png'">

        <?php if ($teamInfo['isOwner']) : ?>
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

    <div class="col-lg-7 teamPanel">

        <div class="header">
            <span class="teamname"><?= $teamDetails->getTeamName(); ?></span>
            <span class="teamid">id: <?= $teamDetails->getId(); ?></span>
        </div>
        <div class="teamInfos">
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'name')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $teamDetails->getTeamName(); ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'shortcode')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $teamDetails->getTeamShortCode(); ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'team_captain')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= Html::a($teamDetails->GetTeamCaptain()->one()->getUsername(), ['/user/details', 'id' => $teamDetails->getTeamCaptainId()]); ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'member_since')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $teamInfo['memberSince']; ?></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'nationality')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"></div>
            </div>
            <div class="entry clearfix">
                <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'description')?></div>
                <div class="col-xs-7 col-sm-9 col-lg-9 context"><?= $teamDetails->getTeamDescription() ?></div>
            </div>
        </div>
        <div class="entry entryMembers clearfix">
            <div class="col-xs-5 col-sm-3 col-lg-3"><?=\app\modules\teams\Module::t('teams', 'team_member')?></div>
            <div class="col-xs-7 col-sm9 col-lg-9 context">
                <?php foreach($teamDetails->getSubTeamMembers()->all() as $userKey => $user): ?>
                    <?php
                        $username = $user->getUser()->one()->getUsername();
                        $userId = $user->getUserId();
                    ?>
                    <div class="col-lg-6 teamMembers"><?= Html::a($username, ['/user/details', 'id' => $userId]); ?>
                        (<?=\app\modules\teams\Module::t('teams', ($teamDetails->isUserSubstitute($userId) ? 'substitude' : 'player'))?>)
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <!-- falls hier noch was reinkommen sollte, auf der rechten Seite ;). -->
    </div>
</div>
