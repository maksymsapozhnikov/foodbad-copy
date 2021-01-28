<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class PageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       'css/_main.css',
    ];
    public $js = [
       'js/_geo.js',
       'js/_main.js'
    ];
    public $depends = [
       'yii\web\YiiAsset',
       'yii\bootstrap\BootstrapAsset',
       'yii\bootstrap\BootstrapPluginAsset'
    ];
}
