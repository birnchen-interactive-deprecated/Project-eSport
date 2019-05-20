<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** Footer Images */
$pespImg = Html::img('../images/PeSpLogos/pesp.webp', ['height' => '50px', 'alt'=> 'twitter', 'aria-label' => 'twitter', 'onerror' => 'this.src=\'../images/PeSpLogos/pesp.png\'']);
$pespLink = Html::a($pespImg, 'https://project-esport.gg', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'eSports League']);

$dvisionImg = Html::img('../images/PeSpLogos/DVision.webp', ['height' => '50px', 'alt'=> 'discord', 'aria-label' => 'discord', 'onerror' => 'this.src=\'../images/PeSpLogos/DVision.png\'', 'style' => 'padding: 5px 0; ']);
$dvisionLink = Html::a($dvisionImg, 'https://www.dvision-diner.com', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'eSports Diner']);

?>

<div class="site-events-overview">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Ort</th>
                <th>Beschreibung</th>
                <th>Links</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>23.08.2019</td>
                <td>Köln</td>
                <td><b>Save the Date!!!</b></td>
                <td>
                    <span><?= $pespLink; ?></span>
                    <span><?= $dvisionLink; ?></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>