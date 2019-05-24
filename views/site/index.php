<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Welcome to Project eSport\'s';

$this->registerLinkTag(['rel' => 'canonical', 'href' => 'https://project-esport.gg' . Yii::$app->request->url]);

Yii::$app->MetaClass->writeMetaIndex($this, $this->title);

?>

<div class="site-index">
    <main>

        <div class="col-lg-9 welcome">
            Willkommen auf unserer Turnier Website.<br>
            Besuch uns doch bei Fragen auf unserem <a class="dclink" href="https://discord.gg/rk3qd9U">Discord</a> Server.
            <br>
            <br>
            Noch kein Team angelegt??? <br>
            Melde dich auf <a class="dclink" href="https://discord.gg/rk3qd9U">Discord</a> bei <b><i><u>Birnchen | Pierre#5366</u></i></b>.

<!-- 
            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="https://project-esport.gg/images/socialMedia/Twitter_Logo_Blue.webp">Twitter</span>
                    <span class="headerTitle">SEASON ENDE FÜR DIVISIONEN 2 &amp; 3</span>
                    <span class="headerDate">25.05.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="/images/teams/mainTeams/2.png" alt="" style="width: 100%;"></div>
                    <div class="containerText col-lg-9">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>
 -->
        </div>

        <div class="col-lg-3">
            <?= Html::a('Tweets by project-eSport', 'https://twitter.com/' . 'esport_project' . '?ref_src=twsrc%5Etfw', ['class' => 'twitter-timeline', 'target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'twitter-timeline', 'label' => 'twitter-timeline', 'data-lang' => 'en', 'data-height' => '400', 'data-theme' => 'light']); ?>
        </div>

    </main>
</div>