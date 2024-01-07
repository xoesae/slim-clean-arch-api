<?php

use Doctrine\ORM\EntityManager;
use Domain\Repository\UserRepositoryInterface;
use Domain\UseCase\UserUseCase;
use Infra\Persistence\Repository\UserRepository;
use Presentation\Http\JsonRenderer;
use Psr\Container\ContainerInterface;
use Slim\App as SlimApp;
use Slim\Factory\AppFactory;

return [
    'settings' => function (): array {
        return require CONFIG_PATH . '/settings.php';
    },

    SlimApp::class => function (ContainerInterface $container): SlimApp {
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

    // Doctrine
    EntityManager::class => require CONFIG_PATH . '/doctrine.php',

    UserRepositoryInterface::class => fn (EntityManager $entityManager) => (new UserRepository($entityManager)),

    UserUseCase::class => fn (UserRepositoryInterface $repository) => (new UserUseCase($repository)),

    JsonRenderer::class => function (): JsonRenderer {
        return new JsonRenderer();
    },
];