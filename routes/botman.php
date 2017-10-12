<?php

use App\Http\Controllers\BotManController;
use BotMan\BotMan\BotMan;

$botman = resolve('botman');

//$payload = $bot->getMessage()->getPayload();
//$replyTo = $payload['message_id'];

// about

$botman->hears('/about{whatever}', function (BotMan $bot) {
    $user = $bot->getUser();
    $username = $user->getUsername();
    $name = $user->getFirstName();

    $bot->typesAndWaits(3);

    $sender = is_null($username)
        ? $name
        : "@" . $username;

    $bot->reply("{$sender},\nEu sou um bot criado por campuseros, para campuseros 😁");
    $bot->reply("Se você quiser saber como eu funciono, pode dar uma olhadinha no meu código:\nhttps://github.com/CampuserosClub/CampuserosBot", [
        'disable_web_page_preview' => true,
    ]);
});

// biscoito ou bolacha
$botman->hears('{any}bolacha{thing}', BotManController::class . '@biscoitoBolacha');
$botman->hears('{any}biscoito{thing}', BotManController::class . '@biscoitoBolacha');