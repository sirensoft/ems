<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MapAsset extends AssetBundle
{
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        '//api.mapbox.com/mapbox.js/v3.0.1/mapbox.css',
        
    ];
    public $js = [
        '//api.mapbox.com/mapbox.js/v3.0.1/mapbox.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
    
}
