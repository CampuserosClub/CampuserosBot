<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class AboutWebhookController extends Controller
{
    protected $baseUrl;
    protected $http;

    public function __construct()
    {
        $this->baseUrl = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN');
        $this->http = new Client();
    }

    public function set()
    {
        $url = $this->baseUrl.'/setWebhook?url='.env('TELEGRAM_BOT_WEBHOOK');
        $this->http->get($url);

        return redirect()->route('webhook.info');
    }

    public function info()
    {
        $url = $this->baseUrl.'/getWebhookInfo';
        $response = $this->http->get($url);

        return (string) $response->getBody();
    }
}
