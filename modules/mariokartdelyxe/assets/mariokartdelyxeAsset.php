<?php

namespace app\modules\mariokartdelyxe\assets;

use yii\web\AssetBundle;

class MariokartdelyxeAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/mariokartdelyxe/assets';

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