<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleHttpClient;

class WebhookController extends Controller
{
    public function define()
    {
        $url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/setWebhook?url='.env('TELEGRAM_BOT_WEBHOOK');
        $client = new GuzzleHttpClient();
        $client->get($url);

        return redirect()->route('webhook.info');
    }

    public function info()
    {
        $url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/getWebhookInfo';
        $client = new GuzzleHttpClient();
        $response = $client->get($url);

        echo $response->getBody();
    }
}
