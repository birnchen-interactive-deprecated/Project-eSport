<?php

namespace app\modules\rocketleague\assets;

use yii\web\AssetBundle;

class RocketleagueAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/rocketleague/assets';

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