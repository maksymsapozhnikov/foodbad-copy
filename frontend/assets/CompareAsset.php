<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CompareAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
       'plugins/lazy/jquery.lazy.min.js',
       'js/compare.js',
    ];
    public $depends = [
       'yii\web\YiiAsset',
    ];
}
