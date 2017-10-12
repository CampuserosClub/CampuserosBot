<?php

use App\Http\Controllers\BotManController;
use BotMan\BotMan\BotMan;

$botman = resolve('botman');


$botman->hears('/about{whatever}', BotManController::class . '@about');
$botman->hears('{any}bolacha{thing}', BotManController::class . '@biscoitoBolacha');
$botman->hears('{any}biscoito{thing}', BotManController::class . '@biscoitoBolacha');
$botman->hears('{any}cafe{thing}', BotManController::class . '@cafe');
$botman->hears('{any}café{thing}', BotManController::class . '@cafe');
$botman->hears('{any}gas{thing}', BotManController::class . '@gas');
$botman->hears('{any}gás{thing}', BotManController::class . '@gas');