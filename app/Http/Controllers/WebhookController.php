<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Triggers\About;
use BotMan\BotMan\BotMan;

class WebhookController extends Controller
{
    public static $triggers = [
        About::class
    ];

    public static function handle(BotMan $bot, $message)
    {
        foreach(self::$triggers as $trigger) {
            new $trigger($bot, $message);
        }
    }
}