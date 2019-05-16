<?php
/* @var $this yii\web\View
 * @var $data array
 * @var $pos int
 */


preg_match_all('/a.*?href=["\'](.*?)["\']/', $data[$pos]['html'], $matches);
foreach ($matches[1] as $key => $match) {
	if (substr_count($match, 'https:') === 1) {
		continue;
	}

	$newLink = strstr(substr($match, 1), 'https:');

	$data[$pos]['html'] = str_replace($match, $newLink, $data[$pos]['html']);
}

foreach ($matches[1] as $key => $match) {
	if (substr_count($match, 'http:') === 0) {
		continue;
	}

	$newLink = strstr(substr($match, 1), 'http:');

	$data[$pos]['html'] = str_replace([$match, 'http:'], [$newLink, 'https:'], $data[$pos]['html']);
}


$this->title = 'Rocket League News';
?>
<div class="rocket-League-news">

    <h1><?= $data[$pos]['title']; ?></h1>
    <p>
        <?= $data[$pos]['html']; ?>
    </p>

</div>