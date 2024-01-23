<?php

return [
    'class'    => \yii\db\Connection::class,
    'dsn'      => printf('pgsql:host=%;dbname=%s', env('DB_HOST'), env('DB_NAME')),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset'  => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
