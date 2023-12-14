<?php

use Psr\Container\ContainerInterface;
use Slim\App as SlimApp;
use Slim\Factory\AppFactory;

return [
    'settings' => function () {
        return require CONFIG_PATH . '/settings.php';
    },

    SlimApp::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        // Register routes
        $files = array_diff(scandir(ROUTES_PATH), ['.', '..']);

        foreach ($files as $file) {
            (require ROUTES_PATH . "/$file")($app);
        }

        // Register middleware
        (require CONFIG_PATH . '/middleware.php')($app);

        return $app;
    },
];