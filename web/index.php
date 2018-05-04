<<<<<<< HEAD
<?php
function debug($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

$ips = [
    '91.212.89.45',
    '127.0.0.1',
];

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    if (in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $ips)) {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
    }
} elseif (isset($_SERVER['REMOTE_ADDR'])) {
    if (in_array($_SERVER['REMOTE_ADDR'], $ips)) {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
    }
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();

=======
<?php
function debug($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

$ips = [
    '91.212.89.45',
    '127.0.0.1',
];

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    if (in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $ips)) {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
    }
} elseif (isset($_SERVER['REMOTE_ADDR'])) {
    if (in_array($_SERVER['REMOTE_ADDR'], $ips)) {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
    }
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();

>>>>>>> oscar-authorization
?>