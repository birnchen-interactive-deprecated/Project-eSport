<?php

/* @var $this yii\web\View */

$this->title = 'Welcome to Project eSport\'s';

$this->registerLinkTag(['rel' => 'canonical', 'href' => 'https://project-esport.gg' . Yii::$app->request->url]);

Yii::$app->MetaClass->writeMetaIndex($this, $this->title);

?>

<div class="site-index">
    <main>
        <div class="welcome">
            Willkommen auf unserer Turnier Website.<br>
            Besuch uns doch bei Fragen auf unserem <a class="dclink" href="https://discord.gg/f6NXNFy">Discord</a> Server.
            <br>
            <br>
            Noch kein Team angelegt??? <br>
            Melde dich auf <a class="dclink" href="https://discord.gg/rk3qd9U">Discord</a> bei <b><i><u>Birnchen | Pierre#5366</u></i></b>.
        </div>
    </main>
</div>