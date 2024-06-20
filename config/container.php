<?php

declare(strict_types=1);

use Laminas\ServiceManager\ServiceManager;

// Load configuration
$config = require __DIR__ . '/config.php'; // at this point all configuration has been merged by ConfigAggregator

$dependencies                       = $config['dependencies']; // this will hold all primary service manager configuration
$dependencies['services']['config'] = $config; // This creates the 'config' service that we can call in our factories

// Build container
return new ServiceManager($dependencies); // create and seed the ServiceManager instance and return it.
