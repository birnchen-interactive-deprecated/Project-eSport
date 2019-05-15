<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

$visible = (Yii::$app->user->isGuest) ? false : true;

$containerClass = '';
if (array_key_exists("r", $_REQUEST) && $_REQUEST['r'] == "site/bracket") {
    $containerClass = 'bracket';
}

$navigation = array(
    array('label' => 'Home', 'url' => ['/site/index'], 'aria-label' => 'Home Button', 'title' => 'Home Button'),
    array('label' => 'News', 'items' => array(
        array('label' => 'Rocket League', 'url' => ['/rocketleague/news'], ['aria-label' => 'RL News Button']),
    )),
    array('label' => 'Teams', 'items' => array(
        array('label' => 'Rocket League', 'url' => ['/rocketleague/teams-overview'], ['aria-label' => 'Rocket League Button']),
    )),
    array('label' => 'Turniere', 'items' => array(
        array('label' => 'Rocket League', 'url' => ['/rocketleague/tournaments'], ['aria-label' => 'RL Tournaments Button']),
    )),
    array('label' => 'Jobs', 'url' => ['/company/jobs'], ['aria-label' => 'Jobs Button']),

);
if (Yii::$app->user->isGuest) {
    $navigation[] = array('label' => 'Login', 'url' => ['/user/login'], ['aria-label' => 'Login Button']);
} else {
    $navigation[] = array('label' => '' . Yii::$app->user->identity->username . '', 'visible' => $visible, 'items' => array(
        array('label' => 'Account', 'url' => ['/user/user/details', 'id' => Yii::$app->user->identity->getId()], ['aria-label' => 'Account Button']),
        array('label' => 'My Teams', 'url' => ['/site/my-teams'], ['aria-label' => 'My Teams Button']),
        array('label' => 'My Tournaments', 'url' => ['/site/my-tournaments'], ['aria-label' => 'My Tournaments Button']),
        array('label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post'], ['aria-label' => 'Logout Button']),
    ));
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => "Project eSport Beta",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $navigation,
    ]);
    NavBar::end();
    ?>

    <div class="container <?= $containerClass; ?>">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php $this->render('@app/views/layouts/_alerts'); ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
