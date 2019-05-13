<?php

namespace app\modules\teams\assets;

use yii\web\AssetBundle;

class TeamsAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/teams/assets';

    public $css = [
        'teamDetails.css'
    ];

    public $js = [
    //    'js/first-js-file.js',
    ];

    // that are the dependencies, for making your Asset bundle work with Yii2 framework
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}