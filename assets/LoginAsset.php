<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/register';
    public $css = [
        'css/font-awesome.min.css',
        'css/bootstrap.min.css',
        'css/mdb.min.css',
        'css/style.css',
        '/css/login.css',
    ];
    public $js = [
        //        'js/jquery-3.2.1.min.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/mdb.min.js',
        'js/main.js',
    ];
    public $depends = [
        //        'yii\web\YiiAsset',
        //        'yii\bootstrap\BootstrapAsset',
    ];
}
