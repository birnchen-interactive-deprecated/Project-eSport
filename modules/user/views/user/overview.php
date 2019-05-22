<?php

/* @var $this yii\web\View
 * @var $pagination array
 * @var $soretedPaginatedUsers array
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Team Details';
?>
<div class="site-player-overview">
	<?php foreach ($soretedPaginatedUsers as $user) : ?>
    	<?php
            $username = $user->getUsername();
            $userId = $user->getId();
        ?>
        <div class="playerRow clearfix">
        	<!-- summe Y aller col-lg-X darf 12 nicht ueberschreiten, sonst bricht es um -->
        	<div class="col-lg-1"><!-- User ID ??? --></div>
	        <div class="col-lg-2"><?= Html::a($username, ['/user/details', 'id' => $userId]); ?></div>
	        <div class="col-lg-2"><!-- Main Teams --></div>
	        <div class="col-lg-2"><!-- Sub Teams --></div>
	        <div class="col-lg-2"><!-- Container 1 --></div>
	        <div class="col-lg-2"><!-- Container 2 --></div>
	        <div class="col-lg-1"><!-- Container 3 --></div>
		</div>
	<?php endforeach; ?>

	<?php
		echo LinkPager::widget([
    		'pagination' => $pagination,
		]);
	?>
</div>