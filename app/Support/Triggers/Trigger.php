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
            if (str_contains($message, $this->triggers)) {
                return true;
            }
        }

        return false;
    }

    protected function handle()
    {
        $this->handleResponses();

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

    /**
     * Action to take if there is a trigger.
     *
     * @return mixed
     */
    protected function run() {
        // NOTHING
    }
}