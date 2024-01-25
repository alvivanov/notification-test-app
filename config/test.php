<?php

declare(strict_types=1);

use app\components\error_handlers\ErrorHandler;

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/test_db.php';
$di     = require __DIR__ . '/di.php';

return [
    'id'         => 'basic-tests',
    'basePath'   => dirname(__DIR__),
    'language'   => 'en-US',
    'components' => [
        'db'           => $db,
        'errorHandler' => [
            'class' => ErrorHandler::class,
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                ['class' => yii\rest\UrlRule::class, 'controller' => 'notifications'],
            ],
        ],
        'request'      => [
            'cookieValidationKey'  => 'test',
            'enableCsrfValidation' => false,
        ],
    ],
    'params'     => $params,
    'container'  => [
        'definitions' => $di,
    ],
];
