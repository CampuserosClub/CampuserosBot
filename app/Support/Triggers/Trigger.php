<?php

namespace App\Support\Triggers;

use Telegram\Bot\Api;

abstract class Trigger
{
    /**
     * @var array
     */
    protected $triggers = [];
    protected $responses = [];
    protected $stickers = [];

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


    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
        $this->update = $telegram->getWebhookUpdates();
        $this->message = $this->update->getMessage();
        $this->chat = $this->message->getChat();

        if ($this->hasTrigger()) {
            $this->handle();
        }
    }

    /**
     * Check if the message has a trigger.
     *
     * @return bool
     */
    protected function hasTrigger()
    {
        if (!is_null($message = $this->message->getText())) {
            return $this->checkText($message, $this->triggers);
        }

        return false;
    }

    /**
     * @param $text
     * @param $check
     *
     * @return bool
     */
    protected function checkText($text, $check)
    {
        return (str_contains(strtolower($text), strtolower($check)));
    }

    protected function handle()
    {
        $this->handleResponses();
        $this->handleStickers();

        $this->run();
    }

    protected function handleResponses()
    {
        $responses = collect($this->responses);

        if (!$responses->isEmpty()) {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat->getId(),
                'text' => $responses->random(),
            ]);
        }
    }

    protected function handleStickers()
    {
        $stickers = collect($this->stickers);

        if (!$stickers->isEmpty()) {
            $this->telegram->sendSticker([
                'chat_id' => $this->chat->getId(),
                'sticker' => $stickers->random(),
            ]);
        }
    }

    /**
     * Action to take if there is a trigger.
     *
     * @return mixed
     */
    protected function run() {
        // NOTHING
    }
}