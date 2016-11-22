<?php

namespace CampuserosBot\Support\Triggers;

use CampuserosBot\Support\Telegram\BaseController;
use Telegram\Bot\Api;

abstract class Trigger extends BaseController
{
    /**
     * @var array
     */
    protected $triggers = [];
    protected $responses = [];
    protected $stickers = [];
    protected $gifs = [];


    public function __construct(Api $telegram)
    {
        parent::__construct($telegram);

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
        return (str_contains(strtolower($text), $check));
    }

    protected function handle()
    {
        $this->handleResponses();
        $this->handleStickers();
        $this->handleGifs();

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

    protected function handleGifs()
    {
        $gifs = collect($this->gifs);

        if (!$gifs->isEmpty()) {
            $this->telegram->sendDocument([
                'chat_id' => $this->chat->getId(),
                'document' => $gifs->random(),
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
        return null;
    }
}