<?php
namespace Nephilim\Controllers;

use \Silex\Application as App;

class Calendar {

  /**
   * Renders the calendar with default year and month
   * @param App $app
   * @return string
   */
  public function indexAction(App $app): string {
    $year = date('Y');
    $month = date('m');

    return $this->fromMonthYearAction($app, $year, $month);
  }

  public function fromMonthYearAction(App $app, int $year, int $month): string {
    $weeks = $app['service.calendar']->findByMonthYear($month, $year);

    return $app->renderView('calendar/calendar.twig', ['weeks' => $weeks,
                'year' => $year,
                'month' => $month,
                'nameMonth' => $app['service.calendar']::MONTH_NAMES[$month]]);
  }
}
