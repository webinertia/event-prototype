<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'data/cache/config-cache.php',
];

$aggregator = new ConfigAggregator([
    \Laminas\HttpHandlerRunner\ConfigProvider::class,
    \Laminas\Diactoros\ConfigProvider::class,
    \Webinertia\Utils\ConfigProvider::class,
    // Include cache configuration
    new ArrayProvider($cacheConfig),

    // Default App module config
    App\ConfigProvider::class, // adds our ConfigProvider to the ServiceManager config
    \User\ConfigProvider::class, // add the User Module to the ServiceManager config
    \Template\ConfigProvider::class, // add template module to the service manager config
    \Mod\ConfigProvider::class, // initialize Mods

    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    // mod config before autoloaded dev config so the dev overrides
    new PhpFileProvider(realpath(__DIR__ . '/../') . '/src/Mod/src/*/mod.config.php'),
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),

    // Load development config if it exists
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
], $cacheConfig['config_cache_path']); // provides a means to cache config in production mode

return $aggregator->getMergedConfig(); // return the merged configuration to /config/container.php
