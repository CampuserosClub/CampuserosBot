<?php

use BotMan\BotMan\BotMan;

Route::post('/', function () {
    $botman = resolve('botman');

    $botman->hears("{message}", function (BotMan $bot, $message) {
        // TODO
    });

    $botman->listen();
});
