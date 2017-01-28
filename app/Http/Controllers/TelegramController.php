<?php

namespace App\Http\Controllers;

use App\Telegram\Api;

class TelegramController extends Controller
{
    protected $telegram;
    protected $update;
    protected $message;
    protected $chat;
    protected $callback;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;

        if (!is_null($this->telegram)) {
            $this->update = $this->telegram->getWebhookUpdates();

            if (!is_null($this->update)) {
                $this->telegram->callback($this->update);
                $this->message = $this->update->getMessage();

                if (!is_null($this->message)) {
                    $this->chat = $this->message->getChat();
                }
            }
        }
    }
}