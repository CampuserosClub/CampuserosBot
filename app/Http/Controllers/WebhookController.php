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
     * @var \Telegram\Bot\Objects\Update
     */
    protected $update;

    /**
     * @var \Telegram\Bot\Objects\Message
     */
    protected $message;

    /**
     * @var \Telegram\Bot\Objects\Chat
     */
    protected $chat;

    /**
     * @var array
     */
    protected $triggers = [
        \App\Support\Triggers\Grito::class,
        \App\Support\Triggers\Pizza::class,
    ];

    /**
     * WebhookController constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
        $this->update = $telegram->getWebhookUpdates();
        $this->message = $this->update->getMessage();
        $this->chat = $this->message->getChat();
    }

    public function handle()
    {
        foreach ($this->triggers as $trigger) {
            new $trigger($this->telegram);
        }
    }
}
