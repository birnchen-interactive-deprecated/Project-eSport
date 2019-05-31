<?php

namespace app\modules\mariokartdeluxe\assets;

use yii\web\AssetBundle;

class MariokartdeluxeAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/mariokartdeluxe/assets';

    public $js = [
    	'https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js',
    	'tournamentOverview.js'
    ];

    public $jsOptions = [
	];
    
    public $css = [
        'teamOverview.css',
        'tournamentOverview.css',
        'tournamentDetails.css'
    ];
}