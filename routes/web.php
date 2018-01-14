<?php

use BotMan\BotMan\BotMan;
use App\Http\Controllers\WebhookController;

Route::post('/', function () {
    $botman = resolve('botman');

    $botman->hears("{message}", function (BotMan $bot, $message) {
        WebhookController::handle($bot, $message);
    });

    $botman->listen();
});