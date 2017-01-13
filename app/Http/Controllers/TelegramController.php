<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;

class TelegramController extends Controller
{
    protected $telegram;
    protected $update;
    protected $message;
    protected $chat;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;

        if (!is_null($this->telegram)) {
            $this->update = $this->telegram->getWebhookUpdates();

            if (!is_null($this->update)) {
                $this->message = $this->update->getMessage();

                if (!is_null($this->message)) {
                    $this->chat = $this->message->getChat();
                }
            }
        }
    }
}