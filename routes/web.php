<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use GuzzleHttp\Client as GuzzleHttpClient;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('setWebhook', function () {
    $url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/setWebhook?url='.env('TELEGRAM_BOT_WEBHOOK');
    $client = new GuzzleHttpClient();
    $client->get($url);

    return redirect()->route('webhook.info');
})->name('webhook.define');

Route::get('infoWebhook', function() {
    $url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/getWebhookInfo';
    $client = new GuzzleHttpClient();
    $response = $client->get($url);

    echo $response->getBody();
})->name('webhook.info');
Route::post('webhook', 'WebhookController@handle')->name('webhook.handle');