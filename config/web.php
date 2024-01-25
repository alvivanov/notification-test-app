<?php

declare(strict_types=1);

use app\components\error_handlers\ErrorHandler;
use yii\caching\FileCache;
use yii\rest\UrlRule;
use yii\web\JsonParser;

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/db.php';
$di     = require __DIR__ . '/di.php';

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wjOslpmpe12YG6eDGcTrDiNgDKCwAJS6',
            'parsers'             => [
                'application/json' => JsonParser::class,
            ],
        ],
        'cache'        => [
            'class' => FileCache::class,
        ],
        'errorHandler' => [
            'class' => ErrorHandler::class,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => $db,
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                ['class' => UrlRule::class, 'controller' => 'notifications'],
            ],
        ],
    ],
    'params'     => $params,
    'container'  => [
        'definitions' => $di,
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][]      = 'gii';
    $config['modules']['gii']   = [
        'class'      => \yii\gii\Module::class,
        'allowedIPs' => ['*', '::1'],
    ];
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class'      => \yii\debug\Module::class,
        'allowedIPs' => ['*', '::1'],
    ];
}

return $config;
