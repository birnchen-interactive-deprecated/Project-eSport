<?php

namespace app\modules\user\assets;

use yii\web\AssetBundle;

class UserAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/user/assets';

    public $js = [
        'https://platform.twitter.com/widgets.js'
    ];

    public $jsOptions = [
   		'async' => 'true'
	];
    
    public $css = [
        'accountOverview.css'
    ];
}