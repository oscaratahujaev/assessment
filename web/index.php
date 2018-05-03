<?php
function debug($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

$ips = [
    '192.168.10.5',
];
if (in_array($_SERVER['REMOTE_ADDR'], $ips)) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();

?>