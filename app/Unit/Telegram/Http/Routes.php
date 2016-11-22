<?php

namespace CampuserosBot\Unit\Telegram\Http;

use CampuserosBot\Core\Unit\Http\Router;
use GuzzleHttp\Client;

class Routes extends Router
{
    public function routes()
    {
        $this->registerWebhookRoutes();

        $this->router->get('/', function () {
            #
        });
    }

    public function registerWebhookRoutes()
    {
        $this->router->group(['prefix' => 'webhook'], function () {

            $this->router->post(NULL, 'TelegramController@webhook');

            $this->router->get('set', function () {
                $url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/setWebhook?url='.env('TELEGRAM_BOT_WEBHOOK');
                $client = new Client();
                $client->get($url);

                return redirect()->route('webhook.info');
            });

            $this->router->get('info', function () {
                $url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/getWebhookInfo';
                $client = new Client();
                $response = $client->get($url);

                return (string) $response->getBody();
            })->name('webhook.info');

        });
    }
}