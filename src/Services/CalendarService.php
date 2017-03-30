<?php
namespace Nephilim\Services;

class CalendarService extends AbstractService
{
    private $table = "calendar_event";

    /**
     *
     */
    public function findByDate(\DateTime $date)
    {
        $sql = "
SELECT `date`, `content`
FROM `{$this->table}`
WHERE `date` = :date
";
        $params = [
            'date' => $date->format('Y-m-d')
        ];

        return $this->app['db']->fetchAssoc($sql, $params);
    }
}
