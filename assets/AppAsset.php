<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/jquery.js',
        'js/jquery.cookie.js',
        'js/popper.min.js',
        'js/bootstrap.js',
        'js/jquery-ui.js',

        'js/specialView.js',
        'js/jquery.vmap.js',
        'js/map.js',
        'js/vmap.uzbekistan.js',
        'js/main.js',
        'js/table.js',
    ];
    public $css = [
        'css/bootstrap.css',
        'css/jqvmap.css',
        'css/jquery-ui.css',
        'css/map.css',

        'css/media.css',
        'css/animate.css',
        'css/fontawesome-all.css',
        'css/style.css',
    ];
    public $depends = [
        //        'yii\web\YiiAsset',
        //        'yii\bootstrap\BootstrapAsset',
    ];
}
