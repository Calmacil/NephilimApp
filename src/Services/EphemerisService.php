<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nephilim\Services;

/**
 * Description of EphemerisService
 *
 * @author calmacil
 */
class EphemerisService extends AbstractService
{
    /**
     * The ephemeris
     * @var array
     */
    private $_ephemeris = [];
    
    /**
     * Populates $_ephemeris with the full ephemeris
     * 
     * @return boolean $success
     */
    private function populateEphemeris(): bool
    {
        if (!$this->_ephemeris) {
            $sql = <<<__SQL__
SELECT `e`.`id`, `zodiac_name`, `k`.`name` AS `ka_name`, `k`.`css_class` AS `ka_class`, `start_day`, `start_month`, `end_day`, `end_month`
FROM ephemeris e
JOIN ka k ON k.id = e.ka_id
__SQL__;
            if (!($rs = $this->app['db']->fetchAll($sql))) {
                return false;
            }
            $this->_ephemeris = $rs;
        }
        return true;
    }
    
    /**
     * Gets the full ephemeris
     * 
     * @return mixed
     */
    public function findAll()
    {
        if (!$this->populateEphemeris()) {
            return false;
        }
        return $this->_ephemeris;
    }
    
    /**
     * Gets a single ephemeris
     * 
     * @param string $id
     * @return type
     */
    public function findById(string $id)
    {
        $sql = <<<__SQL__
SELECT `e`.`id`, `zodiac_name`, `k`.`name` AS `ka_name`, `k`.`class` AS `ka_class`, `start_day`, `start_month`, `end_day`, `end_month`
FROM ephemeris e
JOIN ka k ON k.id = e.ka_id
WHERE `e`.`id` = :id
__SQL__;
        return $this->app['db']->fetchAssoc($sql, ['id' => $id]);
    }
    
    /**
     * Get ephemeris for the given date
     * 
     * @param int $month
     * @param int $day
     * @return array $ephemeris
     */
    public function getForMonthDay(int $month, int $day): array
    {
        if (!$this->populateEphemeris()) {
            return [];
        }
        
        $a = array_filter($this->_ephemeris, function ($var) use ($month, $day) {
            return $month == $var['start_month'] && $day >= $var['start_day']
                    || $month == $var['end_month'] && $day <= $var['end_day'];
        });
        return array_shift($a);
    }
}
