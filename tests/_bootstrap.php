<?php

declare(strict_types=1);

use yii\web\Application;

define('YII_ENV', 'test');
defined('YII_DEBUG') || define('YII_DEBUG', true);

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
new Application(require __DIR__ . '/../config/test.php');

require __DIR__ . '/../vendor/autoload.php';
