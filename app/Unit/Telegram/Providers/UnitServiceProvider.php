<?php

namespace CampuserosBot\Unit\Telegram\Providers;

use CampuserosBot\Core\Unit\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $providers = [
        RouteServiceProvider::class,
    ];
}