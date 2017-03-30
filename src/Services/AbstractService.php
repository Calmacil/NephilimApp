<?php
namespace Nephilim\Services;
use Silex\Application as App;

abstract class AbstractService
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }
}
