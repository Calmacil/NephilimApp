<?php
require_once __DIR__ . '/vendor/autoload.php';
define('ROOT', __DIR__);

use \Nephilim\Application as App;
use \Silex\Provider\TwigServiceProvider;

$app = new App(App::ENV_DEV);

$app->register(new TwigServiceProvider, $app['twig']);


$app->run();
