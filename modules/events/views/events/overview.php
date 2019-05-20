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
	<center>
    	<div><h1><b>Köln 23.08.2019</b></h1></div>
    	<br>
    	<br>
    	<br>
    	<div><h2><b>Save the Date!!!</b></h2></div>
    	<br>
    	<br>
    	<br>
    	<span><?= $pespLink; ?></span><span><?= $dvisionLink; ?>
	</center>
</div>