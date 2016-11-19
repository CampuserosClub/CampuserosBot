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

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('setWebhook', 'WebhookController@define')->name('webhook.define');
Route::get('infoWebhook', 'WebhookController@info')->name('webhook.info');