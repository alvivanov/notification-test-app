<?php

declare(strict_types=1);

use yii\caching\FileCache;
use yii\log\FileTarget;

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/db.php';
$di     = require __DIR__ . '/di.php';

$config = [
    'id'                  => 'basic-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases'             => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components'          => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'log'   => [
            'targets' => [
                [
                    'class'  => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'    => $db,
    ],
    'params'              => $params,
    'container'           => [
        'definitions' => $di,
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][]      = 'gii';
    $config['modules']['gii']   = [
        'class' => \yii\gii\Module::class,
    ];
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];
}

return $config;
