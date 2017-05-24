<?php
namespace Nephilim\Services;

/**
 * @author Calmacil <togo.harrian@gmail.com>
 */
class CalendarService extends AbstractService
{
  private $table = "calendar_event";

  const MONTH_NAMES = [
      1 => "Janvier",
      2 => "Février",
      3 => "Mars",
      4 => "Avril",
      5 => "Mai",
      6 => "Juin",
      7 => "Juillet",
      8 => "Août",
      9 => "Septembre",
      10 => "Octobre",
      11 => "Novembre",
      12 => "Décembre"
  ];

  /**
   * Gets an event by it's date
   * @param \DateTime $date
   * @return array $calendar_event
   */
  public function findByDate(\DateTime $date): array 
  {
    $sql = <<<__SQL__
SELECT `date`, `content`
FROM `{$this->table}`
WHERE `date` = :date
__SQL__;
    $params = ['date' => $date->format('Y-m-d')];

    return $this->app['db']->fetchAssoc($sql, $params);
  }

  /**
   * Gets all events for a given month and a given year
   * @param type $month
   * @param type $year
   * 
   * @return array
   */
  public function findByMonthYear($month, $year): array {
    $sql = <<<__SQL__
SELECT `date`, `content`
FROM `{$this->table}`
WHERE `date` BETWEEN :date_before AND :date_after
__SQL__;

    $params = [
      'date_before' => sprintf("%s-%02s-01", $year, $month),
      'date_after' => sprintf("%s-%02s-%02s", $year, $month, $this->daysInMonth($month, $year)),
    ];

    $events = $this->app['db']->fetchAll($sql, $params);
    if (!$events) {
      $events = [];
    }

    return $this->createCalendarArray($month, $year, $events);
  }

  /**
   * Returns an array of days optionally populated with events
   * @param type $month
   * @param type $year
   * @param type $events
   * 
   * @return array
   */
  private function createCalendarArray(int $month, int $year, array $events = null) {
    $weeks = [];
    $firstDayOfWeekForMonth = date('N', strtotime(sprintf("%d-%02d-01", $year, $month)));

    for ($i = 0; $i < $this->weeksInMonth($month, $year); $i++) {
      $weeks[] = [];

      for ($j = 1; $j <= 7; $j++) {
        $dayNb = ($i * 7 + $j) - $firstDayOfWeekForMonth + 1;
        $notInMonth = ($i == 0 && $j < $firstDayOfWeekForMonth || $dayNb > $this->daysInMonth($month, $year));
        $event = null;

        if (!$notInMonth) {
          $event = $this->extractEventFromArray($dayNb, $month, $year, $events);
        }

        $day = $notInMonth ?
          ['in_month' => false] :
          [
            'in_month' => true,
            'event' => $event,
            'day' => $dayNb,
            'ephemeris' => $this->app['service.ephemeris']->getForMonthDay($month, $dayNb),
          ];
        $weeks[$i][] = $day;
      }
    }
    return $weeks;
  }

  /**
   * 
   * @param int $day
   * @param int $month
   * @param int $year
   * @param array $events
   */
  private function extractEventFromArray(int $day, int $month, int $year, array $events) {
    $refDate = new \DateTime(sprintf("%s-%02s-%02s", $year, $month, $day));

    foreach ($events as $event) {
      $cmpDate = \DateTime::createFromFormat('Y-m-d', $event['date']);
      if ($refDate == $cmpDate->format('Y-m-d')) {
        return $event;
      }
    }
    return null;
  }

  /**
   * Gets nb of days in given month and year
   * @param int $month
   * @param int $year
   * @return int
   */
  private function daysInMonth($month, $year): int {
    return date('t', strtotime("$year-$month-01"));
  }

  /**
   * Gets nb of weeks in a month
   * @param type $month
   * @param type $year
   */
  private function weeksInMonth($month, $year): int {
    $daysInMonth = $this->daysInMonth($month, $year);
    $numOfWeeks = ($daysInMonth % 7 == 0 ? 0 : 1) + intval($daysInMonth / 7);
    $startDay = date('N', strtotime("$year-$month-01"));
    $endDay = date('N', strtotime("$year-$month-$daysInMonth"));

    if ($endDay < $startDay) {
      $numOfWeeks++;
    }

    return $numOfWeeks;
  }

}
