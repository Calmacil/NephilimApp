<?php

namespace Nephilim;

/**
 * @author Calmacil <togo.harrian@gmail.com>
 */
class Application extends \Silex\Application {

  const ENV_DEV = '_dev';
  const ENV_PROD = '';

  /**
   * @var str
   */
  private $environment;

  /**
   * Inits the application
   */
  public function __construct($environnement) {
    parent::__construct();
    $this->environment = $environnement;
    $this->loadConfig();
    $this->loadServices();
    $this->loadRoutes();
  }

  use \Silex\Application\UrlGeneratorTrait;
  use \Silex\Application\TwigTrait;
  use \Silex\Application\FormTrait;

  /**
   * Loads the settings file
   */
  private function loadConfig(): void {
    $file = ROOT . '/config/settings' . $this->environment . '.yml';

    $yml = yaml_parse_file($file);

    array_walk($yml, 'self::compileSettings');

    foreach ($yml as $key => $val) {
      $this->offsetSet($key, $val);
    }
  }

  /**
   * Loads the routes
   */
  private function loadRoutes(): void {
    $file = ROOT . '/config/routes.yml';
    $yml = yaml_parse_file($file);

    foreach ($yml as $bind_name => $route) {

      $method = 'GET';
      if (array_key_exists('method', $route))
        $method = $route['method'];

      $ctrl = $this->match($route['pattern'], $this->getClassName($route['controller']) . "::{$route['action']}Action");

      if (array_key_exists('params', $route)) {
        foreach ($route['params'] as $param => $assertion) {
          if (is_array($assertion) && array_key_exists('converter', $assertion) && $this->offsetExists(implode(':', $assertion['converter']))) {
            $ctrl->convert($param, $assertion['converter']['class'] . ':' . $assertion['converter']['method']);
          } else {
            $ctrl->assert($param, $assertion);
          }
        }
      }
      $ctrl->method($method);
      $ctrl->bind($bind_name);
    }
  }

  private function loadServices(): void {
    $file = ROOT . '/config/services.yml';
    $yml = yaml_parse_file($file);

    foreach ($yml as $service_name => $service) {
      $class = $this->getClassName($service);
      $this->offsetSet($service_name, function($app) use ($class) {
        return new $class($app);
      });
    }
  }

  private function getClassName(string $namespace): string {
    return "\\Nephilim\\" . str_replace('/', '\\', $namespace);
  }

  /**
   * Callback for settings loading
   */
  private function compileSettings(&$item, $key) {
    if (is_array($item))
      array_walk($item, 'self::compileSettings');
    else
      $item = str_replace('ROOT', ROOT, $item);
  }

}
