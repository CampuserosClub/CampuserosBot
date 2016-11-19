<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;

class WebhookController extends Controller
{
    /**
     * @var Api
     */
    protected $telegram;

    /**
     * WebhookController constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle()
    {
        // TODO
    }
}
