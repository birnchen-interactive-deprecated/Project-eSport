<?php

/* @var $this yii\web\View
 * @var $data array
 */

use yii\helpers\Html;

$this->title = 'Welcome to Project eSport\'s';

$this->registerLinkTag(['rel' => 'canonical', 'href' => 'https://project-esport.gg' . Yii::$app->request->url]);

Yii::$app->MetaClass->writeMetaIndex($this, $this->title);

$bigNews = Html::a('<h1>' . $data[0]['title'] . '</h1><p>' . strip_tags($data[0]['html'], '<img><div><br><b><u>') . '</p>', ['/rocketleague/news-details', 'pos' => 0]);
$smallNews1 = Html::a('<h1>' . $data[1]['title'] . '</h1><p>' . strip_tags($data[1]['html'], '<img><div><br><b><u>') . '</p>', ['/rocketleague/news-details', 'pos' => 1]);
$smallNews2 = Html::a('<h1>' . $data[2]['title'] . '</h1><p>' . strip_tags($data[2]['html'], '<img><div><br><b><u>') . '</p>', ['/rocketleague/news-details', 'pos' => 2]);

?>

<div class="site-index">

    <div class="steamNews">

        <div class="bigNews col-lg-9">
            <?= $bigNews; ?>
        </div>

        <div class="smallNews col-lg-3">
            <?= $smallNews1; ?>
        </div>

        <div class="smallNews col-lg-3">
            <?= $smallNews2; ?>
        </div>

    </div>

</div>
