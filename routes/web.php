<?php

Route::get('/', function () {
    // none
});

Route::group(['prefix' => 'webhook'], function () {
    Route::post(null, 'WebhookController@handle');
    Route::get('set', 'AboutWebhookController@set');
    Route::get('info', 'AboutWebhookController@info')->name('webhook.info');
});
