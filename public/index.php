<?php

declare(strict_types=1);

use Webinertia\Utils\Debug;

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keeps the global namespace clean.
 */
(function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require 'config/container.php'; // get an instance of the configured ServiceManager

    //Debug::dump($container, '$container');

    /** @var \Mezzio\Application $app */
    $app = $container->get(\App\App::class); // get a Factoried instance of the Application class

    //Debug::dump($app, '$app');

    $app->run(); // run the Application
})();