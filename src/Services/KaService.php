<?php
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
