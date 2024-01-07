<?php

require_once AUTOLOAD_PATH;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container): EntityManager {
    $settings = $container->get('settings');

    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: [BASE_PATH . '/src'],
        isDevMode: $settings['debug'],
    );

    $connection = DriverManager::getConnection($settings['database'], $config);

    return new EntityManager($connection, $config);
};