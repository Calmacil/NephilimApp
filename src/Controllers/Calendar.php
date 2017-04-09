<?php
namespace Nephilim\Controllers;

use \Silex\Application as App;

class Calendar
{
    public function indexAction(App $app): string
    {
        $dt = new \DateTime('2017-03-02');
        $ce = $app['service.calendar']->findByDate($dt);

        return $app->renderView('calendar/index.twig', ['event'=>$ce]);
    }
}
