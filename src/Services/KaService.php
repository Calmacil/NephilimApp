<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nephilim\Services;

/**
 * Description of KaService
 *
 * @author calmacil
 */
class KaService extends AbstractService
{
    public function findAll()
    {
        $sql = <<<__SQL__
SELECT `id`, `css_class`, `name`
FROM `ka`
__SQL__;
        return $this->app['db']->fetchAll($sql);
    }
    
    public function findById($id)
    {
        $sql = <<<__SQL__
SELECT `id`, `css_class`, `name`
FROM `ka`
WHERE `id` = :id
__SQL__;
        return $this->app['db']->fetchAssoc($sql, ['id' => $id]);
    }
}
