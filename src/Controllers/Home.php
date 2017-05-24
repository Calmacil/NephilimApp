<?php
namespace Nephilim\Controllers;
use Silex\Application as App;

class Home {

  public function indexAction(App $app): string {
    return $app->renderView('home/index.twig');
  }

  public function helloAction(App $app, string $name): string {
    return "Salut " . $app->escape($name) . "!!<br/><a href='" . $app->url('home') . "'>Retour</a>";
  }
}
