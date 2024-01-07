<?php

require_once AUTOLOAD_PATH;

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\App as SlimApp;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Build DI container instance
$container = (new ContainerBuilder())
    ->addDefinitions(CONFIG_PATH . '/container.php')
    ->build();

// Create App instance
return $container->get(SlimApp::class);