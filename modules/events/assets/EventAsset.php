<?php

namespace app\modules\user\assets;

use yii\web\AssetBundle;

class EventAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/events/assets';

    public $js = [
        // 'https://platform.twitter.com/widgets.js'
    ];

    public $jsOptions = [
   		'async' => 'true'
	];
    
    public $css = [
        'events.css'
    ];
}