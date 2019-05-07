<?php

$paramsLocal = require __DIR__ . '/params-local.php';

$params = [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'quandl.apiToken' => 'PUT-YOUR-TOKEN-HERE',
];

$params = array_merge($params, $paramsLocal);

return $params;