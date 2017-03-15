<?php

require_once __DIR__ . '/vendor/autoload.php';
define('ROOT', __DIR__);

use \Nephilim\Application as App;

$app = new App(App::ENV_DEV);

//$app->get('/', function() { return "Hello World!"; })->bind('home');

$app->run();
