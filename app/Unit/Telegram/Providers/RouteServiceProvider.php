<?php

namespace CampuserosBot\Unit\Telegram\Providers;

use CampuserosBot\Unit\Telegram\Http\Routes;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'CampuserosBot\Units\Telegram\Http\Controllers';

    public function map()
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes()
    {
        $options = [
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ];

        (new Routes($options))->register();
    }
}