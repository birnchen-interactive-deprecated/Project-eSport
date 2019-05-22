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
        <div class="col-lg-4"><?= Html::a($username, ['/user/details', 'id' => $userId]); ?></div>
	<?php endforeach; ?>

	<?php
		echo LinkPager::widget([
    		'pagination' => $pagination,
		]);
	?>
</div>