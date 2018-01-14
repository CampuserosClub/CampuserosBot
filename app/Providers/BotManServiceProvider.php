<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BotMan\BotMan\Storages\Drivers\FileStorage;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;

class BotManServiceProvider extends ServiceProvider
{
    public $drivers = [
        TelegramDriver::class
    ];

    public function register()
    {
        foreach($this->drivers as $driver) {
            DriverManager::loadDriver($driver);
        }

        $this->app->singleton('botman', function ($app) {
            $storage = new FileStorage(storage_path('botman'));

            return BotManFactory::create(config('botman', []), new LaravelCache(), $app->make('request'), $storage);
        });
    }
}