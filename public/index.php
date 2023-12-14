<?php declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
define('AUTOLOAD_PATH', dirname(__DIR__) . '/vendor/autoload.php');
define('CONFIG_PATH', dirname(__DIR__) . '/config');
define('ROUTES_PATH', dirname(__DIR__) . '/src/infra/route');

(require CONFIG_PATH . '/bootstrap.php')->run();