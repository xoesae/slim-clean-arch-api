<?php

require_once AUTOLOAD_PATH;

use DI\ContainerBuilder;
use Slim\App as SlimApp;

// Build DI container instance
$container = (new ContainerBuilder())
    ->addDefinitions(CONFIG_PATH . '/container.php')
    ->build();

// Create App instance
return $container->get(SlimApp::class);