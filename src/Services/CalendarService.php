<?php
namespace Nephilim\Services;

/**
 * @author Calmacil <togo.harrian@gmail.com>
 */
class CalendarService extends AbstractService
{
    private $table = "calendar_event";

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
        $params = [
            'date' => $date->format('Y-m-d')
        ];

        return $this->app['db']->fetchAssoc($sql, $params);
    }
    
    public function findByMonthYear($month, $year): array
    {
        $sql = <<<__SQL__
SELECT `date`, `content`
FROM `{$this->table}`
WHERE `date` BETWEEN :date_before AND :date_after
__SQL__;

        $params = [
            'date_before' => '',
            'date_after' => '',
        ];
        
        $events = $this->app['db']->fetchAssoc($sql, $params);
    }
}
