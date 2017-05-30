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
    $form = $app['service.calendar']->getForm();

    $prevMonth = $month - 1;
    if ($prevMonth == 0)
      $prevMonth = 12;
    
    $nextMonth = $month + 1;
    if ($nextMonth == 13)
      $nextMonth = 1;
    
    return $app->renderView('calendar/calendar.twig', ['weeks' => $weeks,
        'year' => $year,
        'month' => $month,
        'prevMonth' => $prevMonth,
        'nextMonth' => $nextMonth,
        'monthName' => $app['service.calendar']::MONTH_NAMES[$month],
        'prevMonthName' => $app['service.calendar']::MONTH_NAMES[$prevMonth],
        'nextMonthName' => $app['service.calendar']::MONTH_NAMES[$nextMonth],
        'form' => $form->createView()
      ]);
  }
}
