<?php

use App\Http\Controllers\BotManController;
use BotMan\BotMan\BotMan;

$botman = resolve('botman');

// about
$botman->hears('/about{whatever}', BotManController::class . '@about');

// biscoito ou bolacha
$botman->hears('{any}bolacha{thing}', BotManController::class . '@biscoitoBolacha');
$botman->hears('{any}biscoito{thing}', BotManController::class . '@biscoitoBolacha');