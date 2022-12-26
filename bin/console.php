<?php

require_once __DIR__ . '/../vendor/autoload.php';
$application = \Myposter\Bootstrap::getInstance();

// Create the Application
$console = new Symfony\Component\Console\Application($_ENV['APP_NAME'], $_ENV['APP_SEMVER']);

// Run it
$console->run();