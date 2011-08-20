<?php

// Nette Framework Microblog example

use Nette\Diagnostics\Debugger;

define("WWW_DIR", __DIR__);
define("APP_DIR", __DIR__ . '/../app');
define("LIBS_DIR", __DIR__ . '/../libs');


// load libraries
require LIBS_DIR . '/Nette/loader.php';
$loader = new \Nette\Loaders\RobotLoader();
$loader->addDirectory(APP_DIR);
$loader->addDirectory(LIBS_DIR);
$loader->register();

// enable Debugger
Debugger::$logDirectory = __DIR__ . '/../log';
Debugger::$strictMode = TRUE;
Debugger::enable();


// enable template router
$configurator = new Nette\Configurator;
$context = $configurator->container;
$context->params['tempDir'] = __DIR__ . '/../temp';
$context->router = new \Nette\Application\Routers\SimpleRouter("Default:default");


// run the application!
$context->application->run();
