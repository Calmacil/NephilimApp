<?php
namespace Nephilim\Controllers;

use \Silex\Application as App;

class Calendar
{
    /**
     * Renders the calendar with default year and month
     * @param App $app
     * @return string
     */
    public function indexAction(App $app): string
    {
        $year = date('Y');
        $month = date('m');

        return $this->fromMonthYear($app, $year, $month);
    }
    
    public function fromMonthYear(App $app, int $year, int $month): string
    {
        $weeks = $app['service.calendar']->findByMonthYear($month, $year);
        
        return $app->renderView('calendar/calendar.twig', ['weeks' => $weeks]);
    }
}
