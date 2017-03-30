<?php
require_once __DIR__ . '/vendor/autoload.php';
define('ROOT', __DIR__);

use \Nephilim\Application as App;
use \Silex\Provider\TwigServiceProvider;
use \Silex\Provider\DoctrineServiceProvider;
use Nephilim\Services\Calendar;

$app = new App(App::ENV_DEV);

$app->register(new TwigServiceProvider, $app['conf.twig'])
    ->register(new DoctrineServiceProvider, $app['conf.doctrine']);

$app->run();
