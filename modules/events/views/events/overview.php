<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** Footer Images */
$pespImg = Html::img('../images/PeSpLogos/pesp.webp', ['height' => '50px', 'alt'=> 'twitter', 'aria-label' => 'twitter', 'onerror' => 'this.src=\'../images/PeSpLogos/pesp.png\'']);
$pespLink = Html::a($pespImg, 'https://project-esport.gg', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'eSports League']);

$dvisionImg = Html::img('../images/PeSpLogos/DVision.webp', ['height' => '50px', 'alt'=> 'discord', 'aria-label' => 'discord', 'onerror' => 'this.src=\'../images/PeSpLogos/DVision.png\'', 'style' => 'padding: 5px 0; ']);
$dvisionLink = Html::a($dvisionImg, 'https://www.dvision-diner.com', ['target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'eSports Diner']);

$holdiImg = Html::img('https://media.discordapp.net/attachments/509042339650600960/580745164486737920/my_logo.jpg?width=492&height=492',['height' => '50px', 'alt'=> 'twitter', 'aria-label' => 'twitter']);
$holdiLink = Html::a($holdiImg, 'https://discord.gg/gqpfaQw', ['target' => '_blank', 'rel' => 'noopener', 'aria-label' => 'HoldieMoldie Discord']);

$gamingAidImg = Html::img('../images/PeSpLogos/gaimingAid.png',['height' => '50px', 'alt'=> 'twitter', 'aria-label' => 'twitter']);
$gamingAidLink = Html::a($gamingAidImg, 'https://gaming-aid.de/', ['target' => '_blank', 'rel' => 'noopener', 'aria-label' => 'Gaming Aid']);

?>

<div class="site-events-overview">
	<center>
    	<div><h1><b>Köln 23.08.2019</b></h1></div>
    	<h2><b>Einlass ab 18:00 Uhr</b></h2>
    	<br>
    	<br>
    	<div><h2><b>Save the Date!!!</b></h2></div>
    	<br>
    	<br>
    	<br>
    	<span><?= $pespLink; ?></span><span><?= $dvisionLink; ?><span><?= $holdiLink; ?><span><?= $gamingAidLink; ?>
	</center>
    <script type="text/javascript" src="https://satellite.booking-time.com/?js=8de288eeadc29aab"></script>
</div>