<?php

// Should be set to 0 in production
error_reporting(E_ALL);

// Should be set to '0' in production
ini_set('display_errors', '1');

$settings = [
    'database' => require CONFIG_PATH . '/database.php',
    'debug' => $_ENV['APP_DEBUG']
];

return $settings;