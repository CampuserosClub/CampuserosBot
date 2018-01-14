<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Triggers\About;
use App\Http\Controllers\Triggers\BiscoitoBolacha;
use App\Http\Controllers\Triggers\Grito;
use App\Http\Controllers\Triggers\Marmotex;
use BotMan\BotMan\BotMan;

class WebhookController extends Controller
{
    public static $triggers = [
        About::class,
        BiscoitoBolacha::class,
        Grito::class,
        Marmotex::class,
    ];

    public static function handle(BotMan $bot, $message)
    {
        foreach(self::$triggers as $trigger) {
            new $trigger($bot, $message);
        }
    }
}