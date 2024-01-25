<?php

declare(strict_types=1);

use yii\db\Connection;

return [
    'class'    => Connection::class,
    'dsn'      => sprintf('%s:host=%s;dbname=%s;port=%s', env('DB_CONNECTION'), env('DB_HOST'), env('DB_DATABASE'), env('DB_PORT')),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset'  => 'utf8',
];
