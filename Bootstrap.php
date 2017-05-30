<?php
require_once __DIR__ . '/vendor/autoload.php';
define('ROOT', __DIR__);

use \Nephilim\Application as App;
use \Silex\Provider\TwigServiceProvider;
use \Silex\Provider\DoctrineServiceProvider;
use \Silex\Provider\FormServiceProvider;
use \Silex\Provider\TranslationServiceProvider;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

$app = new App(App::ENV_DEV);

$app->register(new TwigServiceProvider, $app['conf.twig'])
    ->register(new DoctrineServiceProvider, $app['conf.doctrine'])
    ->register(new FormServiceProvider)
    ->register(new TranslationServiceProvider, $app['conf.translation']);

$app->before(function (Request $req) use ($app)
{
    $app['twig']->addGlobal('active_page', $req->get('_route'));
});

$app->run();
