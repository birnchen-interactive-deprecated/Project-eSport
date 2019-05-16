<?php

/* 
 * @var $this yii\web\View
 * @var $socialMedia array
*/

use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

$visible = (Yii::$app->user->isGuest) ? false : true;
$userID = (Yii::$app->user->isGuest) ? -1 : Yii::$app->user->identity->getId();

/** Footer Images */
$twitterImg = Html::img('../images/socialMedia/Twitter_Logo_Blue.webp', ['height' => '49px', 'alt'=> 'twitter', 'aria-label' => 'twitter', 'onerror' => 'this.src=../images/socialMedia/Twitter_Logo_Blue.png']);
$twitterLink = Html::a($twitterImg, 'https://twitter.com/esport_project', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'Follow us on twitter', 'label' => 'twitter']);

$discordImg = Html::img('../images/socialMedia/Discord-Logo-White.webp', ['height' => '49px', 'alt'=> 'discord', 'aria-label' => 'discord', 'onerror' => 'this.src=../images/socialMedia/Discord-Logo-White.png', 'style' => 'padding: 5px 0; ']);
$discordLink = Html::a($discordImg, 'https://discord.gg/rk3qd9U', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'Join our Discord Server']);

/** some stuff */
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140319651-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-140319651-1');
        gtag('set', {'user_id': '<?php echo $userID; ?>'}); // Legen Sie die User ID mithilfe des Parameters "user_id" des angemeldeten Nutzers fest.
    </script>

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
    <div class="container">
        <div class="col-sm-3 col-lg-3 left_side">
            <span><?= Html::a('Impressum', ['/company/imprint']); ?></span>
            <span><?= Html::a('AGB', ['/company/gtc']); ?></span>
            <span><?= Html::a('Datenschutz', ['/company/privacy']); ?></span>
        </div>
        <div class="col-sm-6 col-lg-6 middle">
            Project-eSport ist eine Marke der Birnchen Interactive. &copy; 2016 - <?= date('Y'); ?>
        </div>
        <div class="col-sm-3 col-lg-3 right_side">
            <span><?= $twitterLink; ?></span>
            <span><?= $discordLink; ?></span>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
