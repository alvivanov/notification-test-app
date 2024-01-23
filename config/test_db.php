<?php
$db = require __DIR__ . '/db.php';

$db['dsn'] = sprintf('%s:host=%s;dbname=%s;port=%s', env('DB_CONNECTION'), env('TEST_DB_HOST'), env('DB_DATABASE'), env('DB_PORT'));

return $db;
