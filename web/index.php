<?php

declare(strict_types=1);

use yii\web\Application;

if (isset($_ENV['DOTENV_FILE'])) {
    define('DOTENV_FILE', $_ENV['DOTENV_FILE']);
}

require __DIR__ . '/../vendor/autoload.php';

defined('YII_DEBUG') || define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') || define('YII_ENV', env('YII_ENV', 'prod'));

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

if (YII_ENV === 'test') {
    $config = require __DIR__ . '/../config/test.php';
}

(new Application($config))->run();
